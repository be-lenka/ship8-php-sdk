<?php
/**
 * ReceivingOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from POST /api/app/receiving/create.
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getId()
 * @method self setId(?string $v)
 * @method ?string getReceivingOrder()
 * @method self setReceivingOrder(?string $v)
 * @method ?string getStatus()
 * @method self setStatus(?string $v)
 * @method ?string getSupplierName()
 * @method self setSupplierName(?string $v)
 * @method ?string getCarrier()
 * @method self setCarrier(?string $v)
 * @method ?string getCarrierSCAC()
 * @method self setCarrierSCAC(?string $v)
 * @method ?string getContainerNo()
 * @method self setContainerNo(?string $v)
 * @method ?string getContainerType()
 * @method self setContainerType(?string $v)
 * @method ?string getBolNo()
 * @method self setBolNo(?string $v)
 * @method ?string getSealNo()
 * @method self setSealNo(?string $v)
 * @method ?\DateTimeInterface getShipDate()
 * @method self setShipDate(?\DateTimeInterface $v)
 * @method ?bool getCrossDocking()
 * @method self setCrossDocking(?bool $v)
 * @method ?string getShipToCode()
 * @method self setShipToCode(?string $v)
 * @method ?string getShipToName()
 * @method self setShipToName(?string $v)
 * @method ?string getShipToCompany()
 * @method self setShipToCompany(?string $v)
 * @method ?string getShipToAddressLine()
 * @method self setShipToAddressLine(?string $v)
 * @method ?string getShipToCity()
 * @method self setShipToCity(?string $v)
 * @method ?string getShipToState()
 * @method self setShipToState(?string $v)
 * @method ?string getShipToZipcode()
 * @method self setShipToZipcode(?string $v)
 * @method ?string getShipToPhone()
 * @method self setShipToPhone(?string $v)
 * @method ?string getShipToEmail()
 * @method self setShipToEmail(?string $v)
 * @method ?string getComment()
 * @method self setComment(?string $v)
 * @method ReceivingLineOutDto[]|null getReceivingLines()
 * @method self setReceivingLines(?array $v)
 */
class ReceivingOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Receivings.Dtos.ReceivingOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'id' => 'string',
        'receivingOrder' => 'string',
        'status' => 'string',
        'supplierName' => 'string',
        'carrier' => 'string',
        'carrierSCAC' => 'string',
        'containerNo' => 'string',
        'containerType' => 'string',
        'bolNo' => 'string',
        'sealNo' => 'string',
        'shipDate' => '\\DateTime',
        'crossDocking' => 'bool',
        'shipToCode' => 'string',
        'shipToName' => 'string',
        'shipToCompany' => 'string',
        'shipToAddressLine' => 'string',
        'shipToCity' => 'string',
        'shipToState' => 'string',
        'shipToZipcode' => 'string',
        'shipToPhone' => 'string',
        'shipToEmail' => 'string',
        'comment' => 'string',
        'receivingLines' => '\\BeLenka\\Ship8\\Model\\ReceivingLineOutDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'id' => 'uuid',
        'shipDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
