<?php

namespace BeLenka\Ship8\Test\Api;

use BeLenka\Ship8\Api\ReturnOrderApi;
use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Configuration;
use BeLenka\Ship8\Model\ReturnOrderCreationDto;
use BeLenka\Ship8\Model\ReturnOrderItemCreationDto;
use BeLenka\Ship8\Model\ReturnOrderItemOutDto;
use BeLenka\Ship8\Model\ReturnOrderOutDto;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ReturnOrderApiTest extends TestCase
{
    private function sampleReturn(): ReturnOrderCreationDto
    {
        return (new ReturnOrderCreationDto())
            ->setCustomerCode('ACME')
            ->setReturnOrderNo('RMA-001')
            ->setReturnDate(new \DateTime('2026-06-01T09:30:00+00:00'))
            ->setTrackingNo('1Z999AA10123456784')
            ->setOrderItems([
                (new ReturnOrderItemCreationDto())
                    ->setItemNo('SKU-1')
                    ->setItemUpc('0001234567890')
                    ->setItemQty(2),
            ]);
    }

    public function testCreateUnwrapsResultDtoAndDeserializesOutDto(): void
    {
        $payload = [
            'successful' => true,
            'code' => '0',
            'message' => 'OK',
            'data' => [
                'id' => '2a3b4c5d-1111-2222-3333-444455556666',
                'webhookReturnOrderID' => 'whk-123',
                'customerCode' => 'ACME',
                'manual' => 0,
                'returnOrderNo' => 'RMA-001',
                'returnDate' => '2026-06-01T09:30:00+00:00',
                'trackingNo' => '1Z999AA10123456784',
                'returnLocation' => 'DC1',
                'status' => 'Received',
                'feedStatus' => 1,
                'feedDate' => '2026-06-02T10:00:00+00:00',
                'orderItems' => [
                    [
                        'lineNo' => 1,
                        'itemNo' => 'SKU-1',
                        'itemUpc' => '0001234567890',
                        'itemDescription' => 'Widget',
                        'itemQty' => 2.0,
                        'returnReason' => 'Damaged',
                        'lineStatus' => 'Open',
                    ],
                ],
            ],
        ];

        $container = [];
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload)),
        ]);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($container));
        $http = new Client(['handler' => $stack]);

        $config = (new Configuration())
            ->setHost('https://sandbox.ship8.com')
            ->setAccessToken('test-token');

        $out = (new ReturnOrderApi($http, $config))->create($this->sampleReturn());

        self::assertInstanceOf(ReturnOrderOutDto::class, $out);
        self::assertSame('RMA-001', $out->getReturnOrderNo());
        self::assertSame('whk-123', $out->getWebhookReturnOrderID());
        self::assertSame('Received', $out->getStatus());
        self::assertSame('DC1', $out->getReturnLocation());
        self::assertInstanceOf(\DateTimeInterface::class, $out->getFeedDate());

        self::assertNotNull($out->getOrderItems());
        self::assertCount(1, $out->getOrderItems());
        self::assertInstanceOf(ReturnOrderItemOutDto::class, $out->getOrderItems()[0]);
        self::assertSame('0001234567890', $out->getOrderItems()[0]->getItemUpc());
        self::assertSame(2.0, $out->getOrderItems()[0]->getItemQty());

        /** @var RequestInterface $req */
        $req = $container[0]['request'];
        self::assertSame('POST', $req->getMethod());
        self::assertSame(
            'https://sandbox.ship8.com/api/app/returnOrder/create',
            (string) $req->getUri()
        );
        self::assertSame('Bearer test-token', $req->getHeaderLine('Authorization'));
        self::assertSame('application/json', $req->getHeaderLine('Content-Type'));

        $body = json_decode((string) $req->getBody(), true);
        self::assertSame('ACME', $body['customerCode']);
        self::assertSame('RMA-001', $body['returnOrderNo']);
        self::assertSame('1Z999AA10123456784', $body['trackingNo']);
        self::assertSame('2026-06-01T09:30:00+00:00', $body['returnDate']);
        self::assertSame(
            [['itemNo' => 'SKU-1', 'itemUpc' => '0001234567890', 'itemQty' => 2]],
            $body['orderItems']
        );
        // optional null fields are dropped from the wire
        self::assertArrayNotHasKey('salesOrderNo', $body);
        self::assertArrayNotHasKey('returnLoc', $body);
    }

    public function testSuccessfulFalseRaisesApiException(): void
    {
        $payload = [
            'successful' => false,
            'code' => 'RETURN_INVALID',
            'message' => 'Return order number already exists',
        ];
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload)),
        ]);
        $http = new Client(['handler' => HandlerStack::create($mock)]);

        $config = (new Configuration())->setHost('https://sandbox.ship8.com')->setAccessToken('jwt');

        $this->expectException(ApiException::class);
        $this->expectExceptionMessageMatches('/RETURN_INVALID/');
        (new ReturnOrderApi($http, $config))->create($this->sampleReturn());
    }
}
