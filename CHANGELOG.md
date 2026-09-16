# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- `ReceivingApi::getStatus()` — `GET /api/app/receiving/get` for reading
  receiving-order progress and short/over-receipt variance without opening the
  Ship8 portal.
- `ReceivingStatusDto` and `ReceivingItemStatusDto` models backing the
  receiving-status lookup. Note `varianceQty = expectedQty - receivedQty`, so a
  positive value means short received and a negative value means over received.
- Optional `$itemNo` and `$upc` filters on `ProductApi::getInventory()`
  (`ItemNo` / `UPC` query parameters), letting Ship8 narrow the inventory
  snapshot server side. Backward compatible: calling `getInventory()` with no
  arguments sends the same request as before and returns the full snapshot.
- `webhookReturnOrderID` field on `ReturnOrderOutDto` (return-order response).

## [0.3.0] - 2026-07-10

### Added
- `ReturnOrderApi::create()` — `POST /api/app/returnOrder/create` for logging
  customer return orders.
- `ReturnOrderCreationDto`, `ReturnOrderItemCreationDto`, `ReturnOrderOutDto`
  and `ReturnOrderItemOutDto` models backing the return-order flow.
- `ultraLight` field on `ItemCreationDto` (product-upsert request) and
  `ultraLight` / `ultraLightText` fields on `ItemCreationOutDto` (response).

## [0.2.0] - 2026-05-25

### Added
- Initial public release.
- 14 Ship8 API endpoints across Account, Order, Shipment, Product,
  InboundPO, Receiving, ReleaseSO, Invoice, Company and
  CustomerFreightQuote resources.
- 40 typed DTOs matching the Ship8 OpenAPI specification.
- `Auth` helper handling JWT request/refresh and storing the resolved
  token on `Configuration`.
- `Configuration::setEnvironment()` as the canonical way to switch
  between sandbox and production hosts; `setHost()` retained as an
  escape hatch for proxies and mocks.
- `ResultDto` unwrapping in `AbstractApi::request()` — callers receive
  the inner `data` payload deserialised into the appropriate model.

[Unreleased]: https://github.com/be-lenka/ship8-php-sdk/compare/v0.3.0...HEAD
[0.3.0]: https://github.com/be-lenka/ship8-php-sdk/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/be-lenka/ship8-php-sdk/releases/tag/v0.2.0
