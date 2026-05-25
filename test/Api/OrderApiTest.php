<?php

namespace BeLenka\Ship8\Test\Api;

use BeLenka\Ship8\Api\OrderApi;
use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Configuration;
use BeLenka\Ship8\Model\OrderCreationDto;
use BeLenka\Ship8\Model\OrderItemCreationDto;
use BeLenka\Ship8\Model\OrderOutDto;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class OrderApiTest extends TestCase
{
    public function testCreateUnwrapsResultDtoAndDeserializesOutDto(): void
    {
        $payload = [
            'successful' => true,
            'code' => '0',
            'message' => 'OK',
            'data' => [
                'id' => '1f2c5a90-1234-4c1c-9aaa-abc123def456',
                'orderNo' => 'SO-001',
                'orderDate' => '2026-05-01T12:00:00+00:00',
                'status' => 'Open',
                'customerCode' => 'ACME',
                'shipToCustomerName' => 'Alice Foo',
                'shipToCity' => 'Austin',
                'orderItems' => [
                    [
                        'lineNo' => 1,
                        'sku' => 'SKU-1',
                        'qtyOrdered' => 5.0,
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

        $order = (new OrderCreationDto())
            ->setCustomerCode('ACME')
            ->setCustomerOrderNo('SO-001')
            ->setCustomerOrderDate(new \DateTime('2026-05-01T00:00:00+00:00'))
            ->setCarrierSCACCode('FDEG')
            ->setCrossDocking(false)
            ->setShipToLevel(OrderCreationDto::SHIP_TO_LEVEL_CUSTOMER)
            ->setShipToCustomerName('Alice Foo')
            ->setShipToAddressLine1('1 Main St')
            ->setShipToCity('Austin')
            ->setShipToState('TX')
            ->setShipToZipCode('78701')
            ->setShipToCountry('US')
            ->setOrderItems([
                (new OrderItemCreationDto())->setItemNo('SKU-1')->setItemQty(5),
            ]);

        $out = (new OrderApi($http, $config))->create($order);

        self::assertInstanceOf(OrderOutDto::class, $out);
        self::assertSame('SO-001', $out->getOrderNo());
        self::assertSame('Open', $out->getStatus());
        self::assertNotNull($out->getOrderItems());
        self::assertCount(1, $out->getOrderItems());

        /** @var RequestInterface $req */
        $req = $container[0]['request'];
        self::assertSame('POST', $req->getMethod());
        self::assertSame(
            'https://sandbox.ship8.com/api/app/order/create',
            (string) $req->getUri()
        );
        self::assertSame('Bearer test-token', $req->getHeaderLine('Authorization'));
        self::assertSame('application/json', $req->getHeaderLine('Content-Type'));

        $body = json_decode((string) $req->getBody(), true);
        self::assertSame('ACME', $body['customerCode']);
        self::assertSame('SO-001', $body['customerOrderNo']);
        self::assertSame('Customer', $body['shipToLevel']);
        self::assertSame([['itemNo' => 'SKU-1', 'itemQty' => 5]], $body['orderItems']);
        // optional null fields are dropped from the wire
        self::assertArrayNotHasKey('shipToEmail', $body);
        self::assertArrayNotHasKey('cancelDate', $body);
    }

    public function testGetSendsQueryParametersAndDeserializes(): void
    {
        $payload = [
            'successful' => true,
            'data' => [
                'id' => 'abc',
                'orderNo' => 'SO-9',
                'status' => 'Shipped',
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
            ->setAccessToken('jwt');

        $out = (new OrderApi($http, $config))->get('ACME', 'SO-9');

        self::assertSame('SO-9', $out->getOrderNo());

        $req = $container[0]['request'];
        self::assertSame('GET', $req->getMethod());
        self::assertSame(
            'https://sandbox.ship8.com/api/app/order/get?customerCode=ACME&orderNo=SO-9',
            (string) $req->getUri()
        );
    }

    public function testSuccessfulFalseRaisesApiException(): void
    {
        $payload = [
            'successful' => false,
            'code' => 'ORDER_INVALID',
            'message' => 'Customer code is invalid',
        ];
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload)),
        ]);
        $http = new Client(['handler' => HandlerStack::create($mock)]);

        $config = (new Configuration())->setHost('https://sandbox.ship8.com')->setAccessToken('jwt');

        $this->expectException(ApiException::class);
        $this->expectExceptionMessageMatches('/ORDER_INVALID/');
        (new OrderApi($http, $config))->get('BAD', 'SO-1');
    }
}
