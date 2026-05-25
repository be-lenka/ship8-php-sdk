<?php
/**
 * ReceivingCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Request body for POST /api/app/receiving/create.
 *
 * `containerType` accepts: LTL, SmallParcel, Container, PalletizedFreight.
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getReceivingOrder()
 * @method self setReceivingOrder(?string $v)
 * @method ?string getSupplier()
 * @method self setSupplier(?string $v)
 * @method ?string getContainerNo()
 * @method self setContainerNo(?string $v)
 * @method ?string getContainerType()
 * @method self setContainerType(?string $v)
 * @method ?string getCarrierSCAC()
 * @method self setCarrierSCAC(?string $v)
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
 * @method ?\DateTimeInterface getEstimatedDeliveryDate()
 * @method self setEstimatedDeliveryDate(?\DateTimeInterface $v)
 * @method ReceivingItemCreationDto[]|null getReceivingItems()
 * @method self setReceivingItems(?array $v)
 */
class ReceivingCreationDto extends AbstractModel
{
    public const CONTAINER_LTL = 'LTL';
    public const CONTAINER_SMALL_PARCEL = 'SmallParcel';
    public const CONTAINER_CONTAINER = 'Container';
    public const CONTAINER_PALLETIZED_FREIGHT = 'PalletizedFreight';

    /** @var string */
    protected static $openAPIModelName = 'Receivings.Dtos.ReceivingCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'receivingOrder' => 'string',
        'supplier' => 'string',
        'containerNo' => 'string',
        'containerType' => 'string',
        'carrierSCAC' => 'string',
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
        'estimatedDeliveryDate' => '\\DateTime',
        'receivingItems' => '\\BeLenka\\Ship8\\Model\\ReceivingItemCreationDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'shipDate' => 'date-time',
        'estimatedDeliveryDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }

    public function listInvalidProperties(): array
    {
        $errors = [];
        $required = ['customerCode', 'receivingOrder', 'supplier', 'containerNo',
            'carrierSCAC', 'bolNo', 'sealNo', 'shipDate', 'crossDocking',
            'shipToCode', 'shipToName', 'shipToAddressLine', 'shipToCity',
            'shipToState', 'shipToZipcode', 'receivingItems'];
        foreach ($required as $f) {
            if (($this->container[$f] ?? null) === null) {
                $errors[] = "'$f' is required.";
            }
        }
        return $errors;
    }
}
