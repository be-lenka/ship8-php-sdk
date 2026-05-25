<?php
/**
 * ShipmentDetailDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-line shipment detail nested inside ShipmentDto.
 *
 * @method ?string getItemNo()
 * @method self setItemNo(?string $v)
 * @method ?float getItemQty()
 * @method self setItemQty(?float $v)
 * @method ShipmentPackDto[]|null getPackDetails()
 * @method self setPackDetails(?array $v)
 */
class ShipmentDetailDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Shipment.Dtos.ShipmentDetailDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'itemNo' => 'string',
        'itemQty' => 'float',
        'packDetails' => '\\BeLenka\\Ship8\\Model\\ShipmentPackDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'itemQty' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
