<?php
/**
 * IncoiveChargeTypeDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-charge breakdown nested inside InvoiceOutDto. Note: the swagger
 * schema name is "Incoive" (typo in the upstream API); both the schema
 * name and the wire field `incoiveChargeTypes` carry the typo so the
 * class name preserves it for fidelity.
 *
 * @method ?string getChargeType()
 * @method self setChargeType(?string $v)
 * @method ?string getReferenceID()
 * @method self setReferenceID(?string $v)
 * @method ?float getTransactionCount()
 * @method self setTransactionCount(?float $v)
 * @method ?float getUnitPrice()
 * @method self setUnitPrice(?float $v)
 * @method ?float getTotalAmount()
 * @method self setTotalAmount(?float $v)
 */
class IncoiveChargeTypeDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Invoice.Dtos.IncoiveChargeTypeDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'chargeType' => 'string',
        'referenceID' => 'string',
        'transactionCount' => 'float',
        'unitPrice' => 'float',
        'totalAmount' => 'float',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'transactionCount' => 'double',
        'unitPrice' => 'double',
        'totalAmount' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
