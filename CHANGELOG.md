# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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

[Unreleased]: https://github.com/be-lenka/ship8-php-sdk/compare/v0.2.0...HEAD
[0.2.0]: https://github.com/be-lenka/ship8-php-sdk/releases/tag/v0.2.0
