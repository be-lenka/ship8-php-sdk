<?php

namespace BeLenka\Ship8\Test\Api;

use BeLenka\Ship8\Api\ReceivingApi;
use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Configuration;
use BeLenka\Ship8\Model\ReceivingCreationDto;
use BeLenka\Ship8\Model\ReceivingItemCreationDto;
use BeLenka\Ship8\Model\ReceivingItemStatusDto;
use BeLenka\Ship8\Model\ReceivingOutDto;
use BeLenka\Ship8\Model\ReceivingStatusDto;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ReceivingApiTest extends TestCase
{
    /**
     * @param array<string, mixed> $payload
     * @param array<int, mixed>    $container
     */
    private function apiFor(array $payload, array &$container): ReceivingApi
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload)),
        ]);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($container));
        $http = new Client(['handler' => $stack]);

        $config = (new Configuration())
            ->setHost('https://sandbox.ship8.com')
            ->setAccessToken('jwt');

        return new ReceivingApi($http, $config);
    }

    public function testGetStatusSendsQueryParametersAndDeserializes(): void
    {
        $payload = [
            'successful' => true,
            'code' => '0',
            'message' => 'OK',
            'data' => [
                'receivingOrder' => 'RO-1001',
                'customerCode' => 'ACME',
                'containerNo' => 'CONT-7',
                'carrierSCAC' => 'FDEG',
                'bolNo' => 'BOL-42',
                'shipDate' => '2026-08-01T00:00:00+00:00',
                'estimatedDeliveryDate' => '2026-08-10T00:00:00+00:00',
                'receivingStatus' => 'Receiving',
                'items' => [
                    [
                        'itemNo' => 'SKU-1',
                        'itemUPC' => '0123456789012',
                        'expectedQty' => 10.0,
                        'receivedQty' => 7.0,
                        'varianceQty' => 3.0,
                        'itemStatus' => 'Open',
                    ],
                    [
                        'itemNo' => 'SKU-2',
                        'itemUPC' => '0123456789029',
                        'expectedQty' => 4.0,
                        'receivedQty' => 6.0,
                        'varianceQty' => -2.0,
                        'itemStatus' => 'Received',
                    ],
                ],
            ],
        ];

        $container = [];
        $out = $this->apiFor($payload, $container)->getStatus('ACME', 'RO-1001');

        self::assertInstanceOf(ReceivingStatusDto::class, $out);
        self::assertSame('RO-1001', $out->getReceivingOrder());
        self::assertSame('ACME', $out->getCustomerCode());
        self::assertSame('Receiving', $out->getReceivingStatus());
        self::assertSame('CONT-7', $out->getContainerNo());
        self::assertSame('BOL-42', $out->getBolNo());
        // all-caps property: pins the magic-accessor derivation on the header too
        self::assertSame('FDEG', $out->getCarrierSCAC());
        self::assertInstanceOf(\DateTimeInterface::class, $out->getShipDate());
        self::assertInstanceOf(\DateTimeInterface::class, $out->getEstimatedDeliveryDate());

        self::assertNotNull($out->getItems());
        self::assertCount(2, $out->getItems());

        $short = $out->getItems()[0];
        self::assertInstanceOf(ReceivingItemStatusDto::class, $short);
        self::assertSame('SKU-1', $short->getItemNo());
        // the point of this test: itemUPC (not itemUpc) round-trips through __call
        self::assertSame('0123456789012', $short->getItemUPC());
        self::assertSame(10.0, $short->getExpectedQty());
        self::assertSame(7.0, $short->getReceivedQty());
        // Variance = expected - received; positive means short received
        self::assertSame(3.0, $short->getVarianceQty());
        self::assertSame('Open', $short->getItemStatus());

        // negative variance means over received
        self::assertSame(-2.0, $out->getItems()[1]->getVarianceQty());

        /** @var RequestInterface $req */
        $req = $container[0]['request'];
        self::assertSame('GET', $req->getMethod());
        self::assertSame(
            'https://sandbox.ship8.com/api/app/receiving/get?customerCode=ACME&receivingOrder=RO-1001',
            (string) $req->getUri()
        );
        self::assertSame('Bearer jwt', $req->getHeaderLine('Authorization'));
    }

    public function testGetStatusEncodesSpecialCharactersInQuery(): void
    {
        $payload = ['successful' => true, 'data' => ['receivingOrder' => 'RO/1001 A']];

        $container = [];
        $this->apiFor($payload, $container)->getStatus('ACME', 'RO/1001 A');

        // RFC3986 encoding: %20 for space, not '+'
        self::assertSame(
            'https://sandbox.ship8.com/api/app/receiving/get?customerCode=ACME&receivingOrder=RO%2F1001%20A',
            (string) $container[0]['request']->getUri()
        );
    }

    public function testGetStatusReturnsNullItemsWhenAbsent(): void
    {
        $payload = [
            'successful' => true,
            'data' => [
                'receivingOrder' => 'RO-2002',
                'customerCode' => 'ACME',
                'receivingStatus' => 'Pending',
            ],
        ];

        $container = [];
        $out = $this->apiFor($payload, $container)->getStatus('ACME', 'RO-2002');

        self::assertSame('Pending', $out->getReceivingStatus());
        // absent `items` yields null, NOT [] — consumers must write `?? []`
        self::assertNull($out->getItems());
        self::assertNull($out->getShipDate());
    }

    public function testGetStatusSuccessfulFalseRaisesApiException(): void
    {
        $payload = [
            'successful' => false,
            'code' => 'RECEIVING_NOT_FOUND',
            'message' => 'Receiving order not found',
        ];

        $container = [];
        $api = $this->apiFor($payload, $container);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessageMatches('/RECEIVING_NOT_FOUND/');
        $api->getStatus('ACME', 'DOES-NOT-EXIST');
    }

    public function testCreateUnwrapsResultDtoAndDeserializesOutDto(): void
    {
        $payload = [
            'successful' => true,
            'code' => '0',
            'message' => 'OK',
            'data' => [
                'id' => '9f8e7d6c-1111-2222-3333-444455556666',
                'customerCode' => 'ACME',
                'receivingOrder' => 'RO-1001',
                'status' => 'Open',
                'supplierName' => 'Supplier Co',
                'carrierSCAC' => 'FDEG',
                'containerNo' => 'CONT-7',
                'bolNo' => 'BOL-42',
                'sealNo' => 'SEAL-9',
                'shipDate' => '2026-08-01T00:00:00+00:00',
                'crossDocking' => false,
                'receivingLines' => [
                    [
                        'lineNo' => 1,
                        'sku' => 'SKU-1',
                        'upc' => '0123456789012',
                        'qtyOrdered' => 10.0,
                        'qtyReceived' => 0.0,
                        'lineStatus' => 'Open',
                    ],
                ],
            ],
        ];

        $receiving = (new ReceivingCreationDto())
            ->setCustomerCode('ACME')
            ->setReceivingOrder('RO-1001')
            ->setSupplier('Supplier Co')
            ->setContainerNo('CONT-7')
            ->setCarrierSCAC('FDEG')
            ->setBolNo('BOL-42')
            ->setSealNo('SEAL-9')
            ->setShipDate(new \DateTime('2026-08-01T00:00:00+00:00'))
            ->setCrossDocking(false)
            ->setShipToCode('DC1')
            ->setShipToName('ACME DC1')
            ->setShipToAddressLine('1 Main St')
            ->setShipToCity('Austin')
            ->setShipToState('TX')
            ->setShipToZipcode('78701')
            ->setReceivingItems([
                (new ReceivingItemCreationDto())
                    ->setItemNo('SKU-1')
                    ->setItemUPC('0123456789012')
                    ->setItemQty(10),
            ]);

        self::assertTrue($receiving->valid(), 'Expected listInvalidProperties to be empty but got: '
            . implode(', ', $receiving->listInvalidProperties()));

        $container = [];
        $out = $this->apiFor($payload, $container)->create($receiving);

        self::assertInstanceOf(ReceivingOutDto::class, $out);
        self::assertSame('RO-1001', $out->getReceivingOrder());
        self::assertSame('Open', $out->getStatus());
        self::assertSame('FDEG', $out->getCarrierSCAC());
        self::assertNotNull($out->getReceivingLines());
        self::assertCount(1, $out->getReceivingLines());
        self::assertSame('SKU-1', $out->getReceivingLines()[0]->getSku());

        /** @var RequestInterface $req */
        $req = $container[0]['request'];
        self::assertSame('POST', $req->getMethod());
        self::assertSame(
            'https://sandbox.ship8.com/api/app/receiving/create',
            (string) $req->getUri()
        );

        $body = json_decode((string) $req->getBody(), true);
        self::assertSame('ACME', $body['customerCode']);
        self::assertSame('RO-1001', $body['receivingOrder']);
        self::assertSame('FDEG', $body['carrierSCAC']);
        self::assertSame(
            [['itemNo' => 'SKU-1', 'itemUPC' => '0123456789012', 'itemQty' => 10]],
            $body['receivingItems']
        );
        // optional null fields are dropped from the wire
        self::assertArrayNotHasKey('shipToEmail', $body);
        self::assertArrayNotHasKey('comment', $body);
    }
}
