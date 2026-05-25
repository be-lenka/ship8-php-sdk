<?php
/**
 * ReceivingLineOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-line receiving response, nested inside ReceivingOutDto.
 *
 * @method ?int getLineNo()
 * @method self setLineNo(?int $v)
 * @method ?string getSku()
 * @method self setSku(?string $v)
 * @method ?string getUpc()
 * @method self setUpc(?string $v)
 * @method ?string getProductDesc()
 * @method self setProductDesc(?string $v)
 * @method ?float getQtyOrdered()
 * @method self setQtyOrdered(?float $v)
 * @method ?float getQtyReceived()
 * @method self setQtyReceived(?float $v)
 * @method ?float getCasePack()
 * @method self setCasePack(?float $v)
 * @method ?string getLineStatus()
 * @method self setLineStatus(?string $v)
 */
class ReceivingLineOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Receivings.Dtos.ReceivingLineOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'lineNo' => 'int',
        'sku' => 'string',
        'upc' => 'string',
        'productDesc' => 'string',
        'qtyOrdered' => 'float',
        'qtyReceived' => 'float',
        'casePack' => 'float',
        'lineStatus' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'lineNo' => 'int32',
        'qtyOrdered' => 'double',
        'qtyReceived' => 'double',
        'casePack' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
