<?php
/**
 * ReturnOrderItemOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-item response payload nested inside ReturnOrderOutDto.
 *
 * Accessors are auto-generated from $openAPITypes via AbstractModel::__call.
 *
 * @method ?int getLineNo()
 * @method self setLineNo(?int $v)
 * @method ?string getItemNo()
 * @method self setItemNo(?string $v)
 * @method ?string getItemUpc()
 * @method self setItemUpc(?string $v)
 * @method ?string getItemDescription()
 * @method self setItemDescription(?string $v)
 * @method ?float getItemQty()
 * @method self setItemQty(?float $v)
 * @method ?string getReturnReason()
 * @method self setReturnReason(?string $v)
 * @method ?string getLineStatus()
 * @method self setLineStatus(?string $v)
 */
class ReturnOrderItemOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ReturnOrders.API.ReturnOrderItemOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'lineNo' => 'int',
        'itemNo' => 'string',
        'itemUpc' => 'string',
        'itemDescription' => 'string',
        'itemQty' => 'float',
        'returnReason' => 'string',
        'lineStatus' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'lineNo' => 'int32',
        'itemQty' => 'double',
    ];

    public static function openAPITypes(): array
    {
        return self::$openAPITypes;
    }

    public static function openAPIFormats(): array
    {
        return self::$openAPIFormats;
    }
}
