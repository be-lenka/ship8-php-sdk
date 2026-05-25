<?php
/**
 * ShipmentDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response item from /api/app/shipment/get. Each entry represents one
 * carrier shipment for the queried order.
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getShipmentNo()
 * @method self setShipmentNo(?string $v)
 * @method ?string getBolNo()
 * @method self setBolNo(?string $v)
 * @method ?string getLoadNo()
 * @method self setLoadNo(?string $v)
 * @method ?\DateTimeInterface getShipDate()
 * @method self setShipDate(?\DateTimeInterface $v)
 * @method ?string getShipMethod()
 * @method self setShipMethod(?string $v)
 * @method ?string getShipFromName()
 * @method self setShipFromName(?string $v)
 * @method ?string getShipFromAddress1()
 * @method self setShipFromAddress1(?string $v)
 * @method ?string getShipFromAddress2()
 * @method self setShipFromAddress2(?string $v)
 * @method ?string getShipFromCity()
 * @method self setShipFromCity(?string $v)
 * @method ?string getShipFromState()
 * @method self setShipFromState(?string $v)
 * @method ?string getShipFromZipCode()
 * @method self setShipFromZipCode(?string $v)
 * @method ?string getShipFromCountry()
 * @method self setShipFromCountry(?string $v)
 * @method ?string getShipToName()
 * @method self setShipToName(?string $v)
 * @method ?string getShipToCompanyName()
 * @method self setShipToCompanyName(?string $v)
 * @method ?string getShipToAddress1()
 * @method self setShipToAddress1(?string $v)
 * @method ?string getShipToAddress2()
 * @method self setShipToAddress2(?string $v)
 * @method ?string getShipToCity()
 * @method self setShipToCity(?string $v)
 * @method ?string getShipToState()
 * @method self setShipToState(?string $v)
 * @method ?string getShipToZipCode()
 * @method self setShipToZipCode(?string $v)
 * @method ?string getShipToCountry()
 * @method self setShipToCountry(?string $v)
 * @method ?string getCustomerOrderNo()
 * @method self setCustomerOrderNo(?string $v)
 * @method ?\DateTimeInterface getCustomerOrderDate()
 * @method self setCustomerOrderDate(?\DateTimeInterface $v)
 * @method ShipmentDetailDto[]|null getItemDetails()
 * @method self setItemDetails(?array $v)
 * @method ?float getTotalShippingCost()
 * @method self setTotalShippingCost(?float $v)
 */
class ShipmentDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Shipment.Dtos.ShipmentDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'shipmentNo' => 'string',
        'bolNo' => 'string',
        'loadNo' => 'string',
        'shipDate' => '\\DateTime',
        'shipMethod' => 'string',
        'shipFromName' => 'string',
        'shipFromAddress1' => 'string',
        'shipFromAddress2' => 'string',
        'shipFromCity' => 'string',
        'shipFromState' => 'string',
        'shipFromZipCode' => 'string',
        'shipFromCountry' => 'string',
        'shipToName' => 'string',
        'shipToCompanyName' => 'string',
        'shipToAddress1' => 'string',
        'shipToAddress2' => 'string',
        'shipToCity' => 'string',
        'shipToState' => 'string',
        'shipToZipCode' => 'string',
        'shipToCountry' => 'string',
        'customerOrderNo' => 'string',
        'customerOrderDate' => '\\DateTime',
        'itemDetails' => '\\BeLenka\\Ship8\\Model\\ShipmentDetailDto[]',
        'totalShippingCost' => 'float',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'shipDate' => 'date-time',
        'customerOrderDate' => 'date-time',
        'totalShippingCost' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
