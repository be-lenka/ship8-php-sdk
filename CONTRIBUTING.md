# Contributing

Thanks for taking the time to contribute. This SDK wraps the public Ship8
OpenAPI spec; the goal is to stay faithful to the spec while keeping the
PHP surface ergonomic and well-typed.

## Reporting issues

Open a GitHub issue at
<https://github.com/be-lenka/ship8-php-sdk/issues>. It helps to include:

- SDK version (`composer show be-lenka/ship8-php-sdk`)
- PHP version (`php -v`)
- A minimal reproducer: the API call you made plus the response or
  exception you got back
- Whether the same call works against the Ship8 sandbox via `curl`
  (helps separate SDK bugs from API behaviour)

## Submitting changes

1. Fork the repo and create a branch off `master`.
2. Install dependencies:

   ```bash
   composer install
   ```

3. Make your change. If you are adding an endpoint or model, mirror the
   shape of an existing sibling — `lib/Api/OrderApi.php` and
   `lib/Model/OrderCreationDto.php` are the canonical references for the
   API and Model layers respectively.
4. Add a test. The suite uses Guzzle's `MockHandler` so no live network
   calls are needed — see `test/Api/OrderApiTest.php` for the pattern.
5. Run the suite and the formatter before pushing:

   ```bash
   ./vendor/bin/phpunit
   ./vendor/bin/php-cs-fixer fix lib/
   ```

6. Open a pull request against `master` with a short description of
   *what* changed and *why*.

## Code style

PSR-12, enforced via `friendsofphp/php-cs-fixer`. The full ruleset lives
in `.php-cs-fixer.dist.php`. Running `php-cs-fixer fix lib/` locally
before pushing avoids CI churn.

## Architecture pointers

- `lib/Api/AbstractApi.php` owns transport and `ResultDto` unwrapping —
  individual API classes are intentionally thin.
- `lib/Model/AbstractModel.php` provides the property-bag base used by
  every DTO; generated models stay drop-in compatible with the
  serializer.
- `lib/Configuration.php` is the single source of truth for environment
  URLs. New environments go in the `ENVIRONMENT_HOSTS` map.
- `resources/swagger.json` is the upstream Ship8 spec. When the spec
  changes, regenerate against this file rather than hand-patching.

## Reporting security issues

Please do **not** open public issues for security vulnerabilities. Use
GitHub's private security advisory feature:
<https://github.com/be-lenka/ship8-php-sdk/security/advisories/new>.
