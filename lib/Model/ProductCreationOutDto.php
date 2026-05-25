<?php
/**
 * ProductCreationOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from POST /api/app/product/upsert.
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ItemCreationOutDto[]|null getItems()
 * @method self setItems(?array $v)
 */
class ProductCreationOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Products.Dtos.ProductCreationOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'items' => '\\BeLenka\\Ship8\\Model\\ItemCreationOutDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
