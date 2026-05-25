<?php
/**
 * InventoryDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from GET /api/app/product/getInventory.
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?\DateTimeInterface getFeedDate()
 * @method self setFeedDate(?\DateTimeInterface $v)
 * @method InventoryDetailDto[]|null getInventoryDetails()
 * @method self setInventoryDetails(?array $v)
 */
class InventoryDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Products.Dtos.InventoryDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'feedDate' => '\\DateTime',
        'inventoryDetails' => '\\BeLenka\\Ship8\\Model\\InventoryDetailDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'feedDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
