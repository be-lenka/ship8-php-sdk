# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What is This?

**Ship8 PHP SDK** — typed PHP client for the Ship8 fulfillment/3PL platform. Wraps 14 API endpoints across order, shipment, inbound PO, receiving, release, product, inventory, invoice, and freight quote operations. Handles JWT authentication, result envelope unwrapping, and model serialization.

## Folder Structure

```
lib/
├── Api/              10 API resource classes (OrderApi, ShipmentApi, etc.)
│   └── AbstractApi   Base transport + ResultDto unwrap
├── Model/            40 DTOs + enums (OrderCreationDto, ShipmentDto, etc.)
│   └── AbstractModel Property bag + ArrayAccess + JSON mapping
├── Auth.php          JWT token request/refresh handler
├── Configuration.php Host, credentials, debug settings
└── ObjectSerializer  Model ↔ JSON mapping, query parameter helpers

test/
├── Api/              Integration tests for API classes
└── Model/            Serialization tests for DTOs

resources/
└── swagger.json      Ship8 OpenAPI spec (source of truth)
```

## Key Commands

```bash
# Install dependencies
composer install

# Run all tests
./vendor/bin/phpunit

# Run single test class
./vendor/bin/phpunit test/Api/OrderApiTest.php

# Format code (PHP CS Fixer)
./vendor/bin/php-cs-fixer fix lib/
```

## Architecture Patterns

- **API classes** extend `AbstractApi` and call `request()`, which handles transport + ResultDto unwrapping
- **Models** extend `AbstractModel` with dynamic getters/setters via `__call()` against `$openAPITypes`
- **Authentication** is stateful (`Auth.authenticate()` stores tokens on `Configuration`)
- **Serialization** uses `ObjectSerializer` for model ↔ JSON conversion and query parameter building
- **Environment selection** is owned by the SDK: `Configuration::setEnvironment(Configuration::ENV_SANDBOX | ENV_PRODUCTION)` is the canonical way to point at a Ship8 host. `setHost()` stays as an escape hatch for proxies/mocks/overrides. URLs live in one place (`ENVIRONMENT_HOSTS`); `getHostSettings()` derives from the same map.

## Key Notes

- Ship8 wraps all responses in `ResultDto { successful, code, message, data }` — `AbstractApi` unwraps to just `data`
- Order query params are camelCase; Shipment query params are PascalCase (documented in code)
- Adding a new endpoint is a one-method change in the corresponding API class
- Credentials should never be hardcoded; pass via `Configuration`
