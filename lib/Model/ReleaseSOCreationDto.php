<?php
/**
 * ReleaseSOCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Request body for POST /api/app/releaseSO/create.
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getReleaseOrderNo()
 * @method self setReleaseOrderNo(?string $v)
 * @method ?\DateTimeInterface getOrderDate()
 * @method self setOrderDate(?\DateTimeInterface $v)
 * @method ?\DateTimeInterface getRequestShipDate()
 * @method self setRequestShipDate(?\DateTimeInterface $v)
 * @method ?string getShipFromLoc()
 * @method self setShipFromLoc(?string $v)
 * @method ?string getScacCode()
 * @method self setScacCode(?string $v)
 * @method ?string getShipToName()
 * @method self setShipToName(?string $v)
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
 * @method ?string getShippingInstructions()
 * @method self setShippingInstructions(?string $v)
 * @method ReleaseSOItemCreationDto[]|null getOrderItems()
 * @method self setOrderItems(?array $v)
 */
class ReleaseSOCreationDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ReleaseSOs.API.ReleaseSOCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'releaseOrderNo' => 'string',
        'orderDate' => '\\DateTime',
        'requestShipDate' => '\\DateTime',
        'shipFromLoc' => 'string',
        'scacCode' => 'string',
        'shipToName' => 'string',
        'shipToCompany' => 'string',
        'shipToAddressLine1' => 'string',
        'shipToZipCode' => 'string',
        'shipToCity' => 'string',
        'shipToState' => 'string',
        'shipToCountry' => 'string',
        'shipToPhone' => 'string',
        'shippingInstructions' => 'string',
        'orderItems' => '\\BeLenka\\Ship8\\Model\\ReleaseSOItemCreationDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'orderDate' => 'date-time',
        'requestShipDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }

    public function listInvalidProperties(): array
    {
        $errors = [];
        foreach (['customerCode', 'orderDate', 'requestShipDate', 'shipFromLoc', 'orderItems'] as $f) {
            if (($this->container[$f] ?? null) === null) {
                $errors[] = "'$f' is required.";
            }
        }
        return $errors;
    }
}
