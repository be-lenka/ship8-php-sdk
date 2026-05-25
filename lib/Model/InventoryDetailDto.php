<?php
/**
 * InventoryDetailDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-SKU inventory line, nested inside InventoryDto.
 *
 * @method ?string getItemNo()
 * @method self setItemNo(?string $v)
 * @method ?string getUpc()
 * @method self setUpc(?string $v)
 * @method ?int getOnHandQty()
 * @method self setOnHandQty(?int $v)
 * @method ?int getFreezeQty()
 * @method self setFreezeQty(?int $v)
 * @method ?int getOpenOrderQty()
 * @method self setOpenOrderQty(?int $v)
 * @method ?int getAllocatedOrderQty()
 * @method self setAllocatedOrderQty(?int $v)
 * @method ?int getTotalAvailableQty()
 * @method self setTotalAvailableQty(?int $v)
 * @method ?int getIncomingQty()
 * @method self setIncomingQty(?int $v)
 * @method ?int getInTransitQty()
 * @method self setInTransitQty(?int $v)
 */
class InventoryDetailDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Products.Dtos.InventoryDetailDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'itemNo' => 'string',
        'upc' => 'string',
        'onHandQty' => 'int',
        'freezeQty' => 'int',
        'openOrderQty' => 'int',
        'allocatedOrderQty' => 'int',
        'totalAvailableQty' => 'int',
        'incomingQty' => 'int',
        'inTransitQty' => 'int',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'onHandQty' => 'int32',
        'freezeQty' => 'int32',
        'openOrderQty' => 'int32',
        'allocatedOrderQty' => 'int32',
        'totalAvailableQty' => 'int32',
        'incomingQty' => 'int32',
        'inTransitQty' => 'int32',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
