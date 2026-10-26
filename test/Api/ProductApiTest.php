<?php

namespace BeLenka\Ship8\Test\Api;

use BeLenka\Ship8\AlreadyExistsException;
use BeLenka\Ship8\Api\ProductApi;
use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Configuration;
use BeLenka\Ship8\Model\InventoryDetailDto;
use BeLenka\Ship8\Model\InventoryDto;
use BeLenka\Ship8\Model\ItemCreationDto;
use BeLenka\Ship8\Model\ProductCreationDto;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ProductApiTest extends TestCase
{
    /**
     * @param array<string, mixed> $payload
     * @param array<int, mixed>    $container
     */
    private function apiFor(array $payload, array &$container): ProductApi
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

        return new ProductApi($http, $config);
    }

    /**
     * @return array<string, mixed>
     */
    private function inventoryPayload(): array
    {
        return [
            'successful' => true,
            'code' => '0',
            'message' => 'OK',
            'data' => [
                'customerCode' => 'ACME',
                'feedDate' => '2026-08-01T00:00:00+00:00',
                'inventoryDetails' => [
                    [
                        'itemNo' => 'SKU-1',
                        'upc' => '0123456789012',
                        'onHandQty' => 42,
                        'totalAvailableQty' => 40,
                    ],
                ],
            ],
        ];
    }

    /**
     * Backward-compatibility guard: a no-argument call must send no query string.
     */
    public function testGetInventoryWithoutFiltersSendsNoQueryString(): void
    {
        $container = [];
        $out = $this->apiFor($this->inventoryPayload(), $container)->getInventory();

        self::assertInstanceOf(InventoryDto::class, $out);
        self::assertSame('ACME', $out->getCustomerCode());
        self::assertInstanceOf(\DateTimeInterface::class, $out->getFeedDate());
        self::assertNotNull($out->getInventoryDetails());
        self::assertCount(1, $out->getInventoryDetails());
        self::assertInstanceOf(InventoryDetailDto::class, $out->getInventoryDetails()[0]);
        self::assertSame('SKU-1', $out->getInventoryDetails()[0]->getItemNo());
        self::assertSame('0123456789012', $out->getInventoryDetails()[0]->getUpc());
        self::assertSame(42, $out->getInventoryDetails()[0]->getOnHandQty());
        self::assertSame(40, $out->getInventoryDetails()[0]->getTotalAvailableQty());

        /** @var RequestInterface $req */
        $req = $container[0]['request'];
        self::assertSame('GET', $req->getMethod());
        self::assertSame(
            'https://sandbox.ship8.com/api/app/product/getInventory',
            (string) $req->getUri()
        );
        self::assertSame('', $req->getUri()->getQuery());
    }

    public function testGetInventoryFiltersByItemNo(): void
    {
        $container = [];
        $this->apiFor($this->inventoryPayload(), $container)->getInventory('SKU-1');

        self::assertSame(
            'https://sandbox.ship8.com/api/app/product/getInventory?ItemNo=SKU-1',
            (string) $container[0]['request']->getUri()
        );
    }

    public function testGetInventoryFiltersByUpcOnly(): void
    {
        $container = [];
        $this->apiFor($this->inventoryPayload(), $container)->getInventory(null, '0123456789012');

        // null $itemNo is stripped
        self::assertSame(
            'https://sandbox.ship8.com/api/app/product/getInventory?UPC=0123456789012',
            (string) $container[0]['request']->getUri()
        );
    }

    public function testGetInventoryFiltersByBothParameters(): void
    {
        $container = [];
        $this->apiFor($this->inventoryPayload(), $container)->getInventory('SKU-1', '0123456789012');

        // key order follows insertion order
        self::assertSame(
            'https://sandbox.ship8.com/api/app/product/getInventory?ItemNo=SKU-1&UPC=0123456789012',
            (string) $container[0]['request']->getUri()
        );
    }

    public function testGetInventoryEncodesSpecialCharactersInFilter(): void
    {
        $container = [];
        $this->apiFor($this->inventoryPayload(), $container)->getInventory('SKU 1');

        // RFC3986 encoding: %20 for space, not '+'
        self::assertSame(
            'https://sandbox.ship8.com/api/app/product/getInventory?ItemNo=SKU%201',
            (string) $container[0]['request']->getUri()
        );
    }

    public function testGetInventorySuccessfulFalseRaisesApiException(): void
    {
        $payload = [
            'successful' => false,
            'code' => 'INVENTORY_UNAVAILABLE',
            'message' => 'Inventory feed is not ready',
        ];

        $container = [];
        $api = $this->apiFor($payload, $container);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessageMatches('/INVENTORY_UNAVAILABLE/');
        $api->getInventory('SKU-1');
    }

    private function upsertFailure(Response $response): ApiException
    {
        $http = new Client(['handler' => HandlerStack::create(new MockHandler([$response]))]);
        $config = (new Configuration())
            ->setHost('https://sandbox.ship8.com')
            ->setAccessToken('jwt');

        $item = (new ItemCreationDto())
            ->setChangeType(ItemCreationDto::CHANGE_TYPE_NEW)
            ->setProductSKU('SKU-1');
        $payload = (new ProductCreationDto())
            ->setCustomerCode('ACME')
            ->setItems([$item]);

        try {
            (new ProductApi($http, $config))->upsert($payload);
        } catch (ApiException $e) {
            return $e;
        }
        self::fail('upsert() did not throw');
    }

    public function testUpsertAlreadyExists403RaisesAlreadyExistsException(): void
    {
        $e = $this->upsertFailure(new Response(403, ['Content-Type' => 'application/json'], json_encode([
            'error' => [
                'code' => '500001',
                'message' => "The product SKU 'SKU-1' already exists.",
                'details' => null,
                'data' => new \stdClass(),
                'validationErrors' => null,
            ],
        ])));

        self::assertInstanceOf(AlreadyExistsException::class, $e);
        self::assertSame(403, $e->getCode());
        self::assertSame('500001', $e->getErrorCode());
        self::assertSame("The product SKU 'SKU-1' already exists.", $e->getErrorMessage());
    }

    public function testUpsertAlreadyExistsEnvelopeRaisesAlreadyExistsException(): void
    {
        $e = $this->upsertFailure(new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'successful' => false,
            'code' => '500001',
            'message' => "The product SKU 'SKU-1' already exists.",
        ])));

        self::assertInstanceOf(AlreadyExistsException::class, $e);
        self::assertSame(200, $e->getCode());
        self::assertSame('500001', $e->getErrorCode());
        // Message format unchanged, so existing "[500001]" checks keep matching.
        self::assertStringStartsWith('[500001] ', $e->getMessage());
    }

    public function testUpsertValidationErrorStaysApiException(): void
    {
        $e = $this->upsertFailure(new Response(400, ['Content-Type' => 'application/json'], json_encode([
            'error' => [
                'code' => null,
                'message' => 'Your request is not valid!',
                'details' => "The following errors were detected during validation.\r\n - Keep two decimals.\r\n",
                'validationErrors' => [['message' => 'Keep two decimals.', 'members' => ['items[0].Weight']]],
            ],
        ])));

        self::assertNotInstanceOf(AlreadyExistsException::class, $e);
        self::assertSame(400, $e->getCode());
        self::assertNull($e->getErrorCode());
        self::assertSame('Your request is not valid!', $e->getErrorMessage());
    }

    public function testUpsert500001WithOtherMessageStaysApiException(): void
    {
        $e = $this->upsertFailure(new Response(403, ['Content-Type' => 'application/json'], json_encode([
            'error' => ['code' => '500001', 'message' => 'Customer is disabled.'],
        ])));

        self::assertNotInstanceOf(AlreadyExistsException::class, $e);
        self::assertSame('500001', $e->getErrorCode());
    }

    public function testUpsertNonJsonErrorBodyHasNoErrorCode(): void
    {
        $e = $this->upsertFailure(new Response(502, ['Content-Type' => 'text/html'], '<html>Bad Gateway</html>'));

        self::assertNotInstanceOf(AlreadyExistsException::class, $e);
        self::assertSame(502, $e->getCode());
        self::assertNull($e->getErrorCode());
        self::assertNull($e->getErrorMessage());
    }
}
