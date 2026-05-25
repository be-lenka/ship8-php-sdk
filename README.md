# Ship8 — PHP SDK

PHP client for the [Ship8](https://ship8.com) fulfillment / 3PL platform.
Provides typed models, JWT authentication and Guzzle-based transport so you
can integrate orders, shipments, inbound POs, receiving, releases, products,
inventory, invoices and freight quotes from any PHP application.

> **Status:** v0.2 — endpoints and models match the published Ship8 OpenAPI
> spec (see `resources/swagger.json`). Authenticated against the sandbox
> environment.

## Installation & Usage

### Requirements

- PHP 7.4 or later (works on PHP 8.x)
- ext-curl, ext-json, ext-mbstring
- Guzzle 6.2+ or 7.x

### Composer

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/be-lenka/ship8-php-sdk.git"
    }
  ],
  "require": {
    "be-lenka/ship8-php-sdk": "*@dev"
  }
}
```

Then run `composer install`.

## Hosts

Ship8 paths begin with `/api/app/...` so the host has no version prefix.

| Environment                              | URL                          |
|------------------------------------------|------------------------------|
| `Configuration::ENV_PRODUCTION`          | `https://portal.ship8.com`   |
| `Configuration::ENV_SANDBOX` *(default)* | `https://sandbox.ship8.com`  |

Select the target environment with `Configuration::setEnvironment()`:

```php
$config = new Configuration();
$config->setEnvironment(Configuration::ENV_SANDBOX);
// $config->getHost() === 'https://sandbox.ship8.com'
```

`setHost()` remains as an escape hatch for proxies, local mocks, or temporary
overrides; it accepts any URL and bypasses the environment table.

## Authentication

Ship8 uses a simplified JWT flow. Exchange your account email + password for
an access token via `POST /api/app/account/requestToken`, then attach
`Authorization: Bearer <token>` to every business call. The `Auth` helper
encapsulates this and stores the resolved token on `Configuration` so any
`Api` instance built from the same `Configuration` picks it up automatically.

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use BeLenka\Ship8\Auth;
use BeLenka\Ship8\Configuration;
use BeLenka\Ship8\Api\OrderApi;
use BeLenka\Ship8\Model\OrderCreationDto;
use BeLenka\Ship8\Model\OrderItemCreationDto;

// 1. Configure the client.
$config = Configuration::getDefaultConfiguration()
    ->setEnvironment(Configuration::ENV_SANDBOX);

// 2. Authenticate. Credentials should come from your app config — never
// hard-code them.
$auth = new Auth($email, $password, $config);
$auth->authenticate();

// 3. Call the API.
$orderApi = new OrderApi(null, $config);

$order = (new OrderCreationDto())
    ->setCustomerCode('ACME')
    ->setCustomerOrderNo('SO-001')
    ->setCustomerOrderDate(new \DateTime())
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

try {
    $out = $orderApi->create($order);
    printf("Created %s — status %s\n", $out->getOrderNo(), $out->getStatus());
} catch (\BeLenka\Ship8\ApiException $e) {
    fwrite(STDERR, sprintf("Ship8 error [%d]: %s\n", $e->getCode(), $e->getMessage()));
}
```

When the access token expires you can rotate it without re-prompting for the
password:

```php
$auth->refresh(); // uses the access + refresh tokens captured during authenticate()
```

## Response envelope

Ship8 wraps every response in a `ResultDto` envelope:

```json
{ "successful": true, "code": "0", "message": "OK", "data": { ... } }
```

`AbstractApi` unwraps this transparently: SDK callers receive the inner `data`
deserialized into the appropriate model. When `successful` is `false`, an
`ApiException` is raised carrying the server's `code` and `message`.

## API endpoints

| Class                       | Method                       | HTTP                                                              |
|-----------------------------|------------------------------|-------------------------------------------------------------------|
| `AccountApi`                | `requestToken`               | `POST /api/app/account/requestToken`                              |
| `AccountApi`                | `refreshToken`               | `POST /api/app/account/refreshToken`                              |
| `OrderApi`                  | `create`                     | `POST /api/app/order/create`                                      |
| `OrderApi`                  | `get`                        | `GET  /api/app/order/get`                                         |
| `ShipmentApi`               | `get`                        | `GET  /api/app/shipment/get`                                      |
| `ProductApi`                | `upsert`                     | `POST /api/app/product/upsert`                                    |
| `ProductApi`                | `getInventory`               | `GET  /api/app/product/getInventory`                              |
| `InboundPOApi`              | `create`                     | `POST /api/app/inboundPO/create`                                  |
| `InboundPOApi`              | `createEECBondedDC`          | `POST /api/app/inboundPO/createEECBondedDC`                       |
| `ReceivingApi`              | `create`                     | `POST /api/app/receiving/create`                                  |
| `ReleaseSOApi`              | `create`                     | `POST /api/app/releaseSO/create`                                  |
| `InvoiceApi`                | `list`                       | `GET  /api/app/invoice/list`                                      |
| `CompanyApi`                | `getBondedDCCompany`         | `GET  /api/app/company/getBondedDCCompany`                        |
| `CustomerFreightQuoteApi`   | `getEstimatedShippingCost`   | `POST /api/app/customerFreightQuote/getEstimatedShippingCost`     |

## Architecture

```
lib/
├── Configuration.php       host, credentials, debug, user-agent
├── Auth.php                Ship8 JWT (requestToken / refreshToken)
├── ApiException.php        thrown for non-2xx / business-level errors
├── HeaderSelector.php      Accept / Content-Type negotiation
├── ObjectSerializer.php    model <-> JSON mapping, query helpers
├── Api/
│   ├── AbstractApi.php     transport + ResultDto unwrap
│   ├── AccountApi.php
│   ├── OrderApi.php
│   ├── ShipmentApi.php
│   ├── ProductApi.php
│   ├── InboundPOApi.php
│   ├── ReceivingApi.php
│   ├── ReleaseSOApi.php
│   ├── InvoiceApi.php
│   ├── CompanyApi.php
│   └── CustomerFreightQuoteApi.php
└── Model/
    ├── ModelInterface.php
    ├── AbstractModel.php   shared property bag + ArrayAccess + JSON
    │                       (auto getXxx/setXxx via __call against $openAPITypes)
    └── *Dto.php            one-to-one with swagger schemas
```

Each operation is a thin wrapper on top of `AbstractApi::request()`; adding a
new endpoint is a one-method change.

## Tests

```bash
composer install
./vendor/bin/phpunit
```

## API Coverage

The SDK provides complete implementation coverage of the Ship8 OpenAPI specification. The swagger definition is sourced from https://portal.ship8.com/swagger/Public/swagger.json and stored locally in `resources/swagger.json` for reference.

### Coverage Summary

| Metric | Coverage |
|--------|----------|
| API Endpoints | 14/14 (100%) |
| Request/Response Models | 23/23 (100%) |
| Total Implemented Models | 40 |

### Implemented Resources

- **Account** (2 endpoints) — JWT token request & refresh
- **Company** (1 endpoint) — Bonded DC company info
- **Order** (2 endpoints) — Create & retrieve orders
- **Shipment** (1 endpoint) — Retrieve shipment details
- **Product** (2 endpoints) — Upsert products & query inventory
- **InboundPO** (2 endpoints) — Create inbound POs (standard & EEC bonded DC)
- **Receiving** (1 endpoint) — Create receiving orders
- **ReleaseSO** (1 endpoint) — Create release SO
- **Invoice** (1 endpoint) — List invoices
- **CustomerFreightQuote** (1 endpoint) — Estimate shipping costs

All request/response data transfer objects are typed and match the Ship8 API specification.

## License

MIT — see `composer.json`.
