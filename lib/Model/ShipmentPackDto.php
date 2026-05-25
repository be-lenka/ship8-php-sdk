<?php
/**
 * ShipmentPackDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-pack detail nested inside ShipmentDetailDto.
 *
 * @method ?string getPackID()
 * @method self setPackID(?string $v)
 * @method ?float getPackQty()
 * @method self setPackQty(?float $v)
 * @method string[]|null getIdentifiers()
 * @method self setIdentifiers(?array $v)
 * @method ?float getShippingCost()
 * @method self setShippingCost(?float $v)
 */
class ShipmentPackDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Shipment.Dtos.ShipmentPackDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'packID' => 'string',
        'packQty' => 'float',
        'identifiers' => 'string[]',
        'shippingCost' => 'float',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'packQty' => 'double',
        'shippingCost' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
