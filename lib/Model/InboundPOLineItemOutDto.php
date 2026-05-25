<?php
/**
 * InboundPOLineItemOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-line response payload nested inside InboundPOOutDto.
 *
 * @method ?int getLineNo()
 * @method self setLineNo(?int $v)
 * @method ?string getSku()
 * @method self setSku(?string $v)
 * @method ?string getUpc()
 * @method self setUpc(?string $v)
 * @method ?string getProductDesc()
 * @method self setProductDesc(?string $v)
 * @method ?float getCasePack()
 * @method self setCasePack(?float $v)
 * @method ?float getQtyOrdered()
 * @method self setQtyOrdered(?float $v)
 * @method ?float getQtyReceived()
 * @method self setQtyReceived(?float $v)
 * @method ?float getQtyVariance()
 * @method self setQtyVariance(?float $v)
 * @method ?string getLineStatus()
 * @method self setLineStatus(?string $v)
 */
class InboundPOLineItemOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'InboundPOs.InboundPOLineItemOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'lineNo' => 'int',
        'sku' => 'string',
        'upc' => 'string',
        'productDesc' => 'string',
        'casePack' => 'float',
        'qtyOrdered' => 'float',
        'qtyReceived' => 'float',
        'qtyVariance' => 'float',
        'lineStatus' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'lineNo' => 'int32',
        'casePack' => 'double',
        'qtyOrdered' => 'double',
        'qtyReceived' => 'double',
        'qtyVariance' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
