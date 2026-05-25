<?php
/**
 * OrderOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from /api/app/order/get and /api/app/order/create.
 *
 * Accessors are auto-generated from $openAPITypes via AbstractModel::__call.
 *
 * @method ?string getId()
 * @method self setId(?string $v)
 * @method ?string getOrderNo()
 * @method self setOrderNo(?string $v)
 * @method ?string getCustomerRetailOrderNo()
 * @method self setCustomerRetailOrderNo(?string $v)
 * @method ?\DateTimeInterface getOrderDate()
 * @method self setOrderDate(?\DateTimeInterface $v)
 * @method ?string getCarrierSCACCode()
 * @method self setCarrierSCACCode(?string $v)
 * @method ?string getShipTo()
 * @method self setShipTo(?string $v)
 * @method ?string getBusinessLine()
 * @method self setBusinessLine(?string $v)
 * @method ?string getStatus()
 * @method self setStatus(?string $v)
 * @method ?bool getHold()
 * @method self setHold(?bool $v)
 * @method ?string getShipToCustomerName()
 * @method self setShipToCustomerName(?string $v)
 * @method ?string getShipToCompany()
 * @method self setShipToCompany(?string $v)
 * @method ?string getShipToPhone()
 * @method self setShipToPhone(?string $v)
 * @method ?string getShipToAddressLine1()
 * @method self setShipToAddressLine1(?string $v)
 * @method ?string getShipToAddressLine2()
 * @method self setShipToAddressLine2(?string $v)
 * @method ?string getShipToEmail()
 * @method self setShipToEmail(?string $v)
 * @method ?string getShipToZipCode()
 * @method self setShipToZipCode(?string $v)
 * @method ?string getShipToCity()
 * @method self setShipToCity(?string $v)
 * @method ?string getShipToState()
 * @method self setShipToState(?string $v)
 * @method ?string getShipToCountry()
 * @method self setShipToCountry(?string $v)
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?bool getCrossDocking()
 * @method self setCrossDocking(?bool $v)
 * @method ?\DateTimeInterface getRequestShipDate()
 * @method self setRequestShipDate(?\DateTimeInterface $v)
 * @method ?\DateTimeInterface getCancelDate()
 * @method self setCancelDate(?\DateTimeInterface $v)
 * @method ?string getShippingInstructions()
 * @method self setShippingInstructions(?string $v)
 * @method ?string getCustomerNotes()
 * @method self setCustomerNotes(?string $v)
 * @method ?string getSignatureRequired()
 * @method self setSignatureRequired(?string $v)
 * @method OrderItemDto[]|null getOrderItems()
 * @method self setOrderItems(?array $v)
 */
class OrderOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Dtos.OrderOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'id' => 'string',
        'orderNo' => 'string',
        'customerRetailOrderNo' => 'string',
        'orderDate' => '\\DateTime',
        'carrierSCACCode' => 'string',
        'shipTo' => 'string',
        'businessLine' => 'string',
        'status' => 'string',
        'hold' => 'bool',
        'shipToCustomerName' => 'string',
        'shipToCompany' => 'string',
        'shipToPhone' => 'string',
        'shipToAddressLine1' => 'string',
        'shipToAddressLine2' => 'string',
        'shipToEmail' => 'string',
        'shipToZipCode' => 'string',
        'shipToCity' => 'string',
        'shipToState' => 'string',
        'shipToCountry' => 'string',
        'billToCustomerName' => 'string',
        'billToCompany' => 'string',
        'billToAddressLine1' => 'string',
        'billToAddressLine2' => 'string',
        'billToCity' => 'string',
        'billToState' => 'string',
        'billToZipCode' => 'string',
        'billToCountry' => 'string',
        'billToPhone' => 'string',
        'billToEmail' => 'string',
        'customerCode' => 'string',
        'crossDocking' => 'bool',
        'thirdPartyCarrier' => 'string',
        'thirdPartyAccount' => 'string',
        'thirdPartyPostal' => 'string',
        'requestShipDate' => '\\DateTime',
        'cancelDate' => '\\DateTime',
        'shippingInstructions' => 'string',
        'customerNotes' => 'string',
        'signatureRequired' => 'string',
        'orderItems' => '\\BeLenka\\Ship8\\Model\\OrderItemDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'id' => 'uuid',
        'orderDate' => 'date-time',
        'requestShipDate' => 'date-time',
        'cancelDate' => 'date-time',
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
