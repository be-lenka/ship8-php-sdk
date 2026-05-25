<?php
/**
 * InvoiceOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Item in the response array from GET /api/app/invoice/list.
 *
 * @method ?string getInvoiceID()
 * @method self setInvoiceID(?string $v)
 * @method ?\DateTimeInterface getInvoiceDate()
 * @method self setInvoiceDate(?\DateTimeInterface $v)
 * @method ?string getInvoiceCategory()
 * @method self setInvoiceCategory(?string $v)
 * @method ?float getInvoiceAmount()
 * @method self setInvoiceAmount(?float $v)
 * @method IncoiveChargeTypeDto[]|null getIncoiveChargeTypes()
 * @method self setIncoiveChargeTypes(?array $v)
 */
class InvoiceOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Invoice.Dtos.InvoiceOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'invoiceID' => 'string',
        'invoiceDate' => '\\DateTime',
        'invoiceCategory' => 'string',
        'invoiceAmount' => 'float',
        'incoiveChargeTypes' => '\\BeLenka\\Ship8\\Model\\IncoiveChargeTypeDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'invoiceDate' => 'date-time',
        'invoiceAmount' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
