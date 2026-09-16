<?php
/**
 * ReturnOrderOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from /api/app/returnOrder/create.
 *
 * Accessors are auto-generated from $openAPITypes via AbstractModel::__call.
 *
 * @method ?string getId()
 * @method self setId(?string $v)
 * @method ?string getWebhookReturnOrderID()
 * @method self setWebhookReturnOrderID(?string $v)
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getSalesOrderNo()
 * @method self setSalesOrderNo(?string $v)
 * @method ?int getManual()
 * @method self setManual(?int $v)
 * @method ?string getReturnOrderNo()
 * @method self setReturnOrderNo(?string $v)
 * @method ?\DateTimeInterface getReturnDate()
 * @method self setReturnDate(?\DateTimeInterface $v)
 * @method ?string getTrackingNo()
 * @method self setTrackingNo(?string $v)
 * @method ?string getReturnLocation()
 * @method self setReturnLocation(?string $v)
 * @method ?string getCustomerName()
 * @method self setCustomerName(?string $v)
 * @method ?string getAddressLine1()
 * @method self setAddressLine1(?string $v)
 * @method ?string getCity()
 * @method self setCity(?string $v)
 * @method ?string getState()
 * @method self setState(?string $v)
 * @method ?string getZipCode()
 * @method self setZipCode(?string $v)
 * @method ?string getCountry()
 * @method self setCountry(?string $v)
 * @method ?string getStatus()
 * @method self setStatus(?string $v)
 * @method ?int getFeedStatus()
 * @method self setFeedStatus(?int $v)
 * @method ?\DateTimeInterface getFeedDate()
 * @method self setFeedDate(?\DateTimeInterface $v)
 * @method ReturnOrderItemOutDto[]|null getOrderItems()
 * @method self setOrderItems(?array $v)
 */
class ReturnOrderOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ReturnOrders.API.ReturnOrderOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'id' => 'string',
        'webhookReturnOrderID' => 'string',
        'customerCode' => 'string',
        'salesOrderNo' => 'string',
        'manual' => 'int',
        'returnOrderNo' => 'string',
        'returnDate' => '\\DateTime',
        'trackingNo' => 'string',
        'returnLocation' => 'string',
        'customerName' => 'string',
        'addressLine1' => 'string',
        'city' => 'string',
        'state' => 'string',
        'zipCode' => 'string',
        'country' => 'string',
        'status' => 'string',
        'feedStatus' => 'int',
        'feedDate' => '\\DateTime',
        'orderItems' => '\\BeLenka\\Ship8\\Model\\ReturnOrderItemOutDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'id' => 'uuid',
        'manual' => 'int32',
        'returnDate' => 'date-time',
        'feedStatus' => 'int32',
        'feedDate' => 'date-time',
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
