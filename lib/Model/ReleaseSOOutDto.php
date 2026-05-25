<?php
/**
 * ReleaseSOOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from POST /api/app/releaseSO/create.
 *
 * @method ?string getId()
 * @method self setId(?string $v)
 * @method ?string getOrderNo()
 * @method self setOrderNo(?string $v)
 * @method ?string getStatus()
 * @method self setStatus(?string $v)
 * @method ?\DateTimeInterface getOrderDate()
 * @method self setOrderDate(?\DateTimeInterface $v)
 * @method ?\DateTimeInterface getRequestShipDate()
 * @method self setRequestShipDate(?\DateTimeInterface $v)
 * @method ?string getShipFrom()
 * @method self setShipFrom(?string $v)
 * @method ?string getShipToCustomerName()
 * @method self setShipToCustomerName(?string $v)
 * @method ?string getShipToCompany()
 * @method self setShipToCompany(?string $v)
 * @method ?string getShipToAddressLine1()
 * @method self setShipToAddressLine1(?string $v)
 * @method ?string getShipToZipCode()
 * @method self setShipToZipCode(?string $v)
 * @method ?string getShipToCity()
 * @method self setShipToCity(?string $v)
 * @method ?string getShipToState()
 * @method self setShipToState(?string $v)
 * @method ?string getShipToCountry()
 * @method self setShipToCountry(?string $v)
 * @method ?string getShipToPhone()
 * @method self setShipToPhone(?string $v)
 * @method ?string getScacCode()
 * @method self setScacCode(?string $v)
 * @method ?string getShippingInstructions()
 * @method self setShippingInstructions(?string $v)
 * @method ?string getCompanyCode()
 * @method self setCompanyCode(?string $v)
 * @method ReleaseSOItemCreationOutDto[]|null getOrderItems()
 * @method self setOrderItems(?array $v)
 */
class ReleaseSOOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ReleaseSOs.API.ReleaseSOOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'id' => 'string',
        'orderNo' => 'string',
        'status' => 'string',
        'orderDate' => '\\DateTime',
        'requestShipDate' => '\\DateTime',
        'shipFrom' => 'string',
        'shipToCustomerName' => 'string',
        'shipToCompany' => 'string',
        'shipToAddressLine1' => 'string',
        'shipToZipCode' => 'string',
        'shipToCity' => 'string',
        'shipToState' => 'string',
        'shipToCountry' => 'string',
        'shipToPhone' => 'string',
        'scacCode' => 'string',
        'shippingInstructions' => 'string',
        'companyCode' => 'string',
        'orderItems' => '\\BeLenka\\Ship8\\Model\\ReleaseSOItemCreationOutDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'id' => 'uuid',
        'orderDate' => 'date-time',
        'requestShipDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
