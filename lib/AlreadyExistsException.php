<?php
/**
 * AlreadyExistsException
 *
 * @category Class
 * @package  BeLenka\Ship8
 */

namespace BeLenka\Ship8;

/**
 * Ship8 rejected a create because the record already exists, e.g. a product
 * upsert with `changeType=New` for a known SKU:
 * `[403] {"error":{"code":"500001","message":"The product SKU 'X' already exists."}}`.
 *
 * Extends ApiException, so existing `catch (ApiException $e)` blocks and
 * `[500001]` message checks keep matching.
 *
 * @category Class
 * @package  BeLenka\Ship8
 */
class AlreadyExistsException extends ApiException
{
    public const ERROR_CODE = '500001';

    /**
     * The message is checked as well as the code, so a 500001 reused for another
     * business error stays a plain ApiException instead of being read as a duplicate.
     */
    public static function matches(ApiException $e): bool
    {
        return $e->getErrorCode() === self::ERROR_CODE
            && stripos((string) $e->getErrorMessage(), 'already exist') !== false;
    }
}
