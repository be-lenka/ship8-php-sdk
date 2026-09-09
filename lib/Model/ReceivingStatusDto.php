<?php
/**
 * ReceivingStatusDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from GET /api/app/receiving/get — receiving order status.
 *
 * This is a deliberately narrower shape than {@see ReceivingOutDto}, which is
 * what POST /api/app/receiving/create returns. It carries the header
 * identifiers plus per line expected/received/variance quantities, and none of
 * the ship-to block, supplier, seal or cross-docking fields.
 *
 * `receivingStatus` is one of Pending / Open / Receiving / Received /
 * Cancelled. Upstream declares it a free-form string rather than an enum, so
 * it is not modelled as constants.
 *
 * `getItems()` is null when the payload omits the key, so read it as
 * `$status->getItems() ?? []` rather than iterating the raw return value.
 *
 * @method ?string getReceivingOrder()
 * @method self setReceivingOrder(?string $v)
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getContainerNo()
 * @method self setContainerNo(?string $v)
 * @method ?string getCarrierSCAC()
 * @method self setCarrierSCAC(?string $v)
 * @method ?string getBolNo()
 * @method self setBolNo(?string $v)
 * @method ?\DateTimeInterface getShipDate()
 * @method self setShipDate(?\DateTimeInterface $v)
 * @method ?\DateTimeInterface getEstimatedDeliveryDate()
 * @method self setEstimatedDeliveryDate(?\DateTimeInterface $v)
 * @method ?string getReceivingStatus()
 * @method self setReceivingStatus(?string $v)
 * @method ReceivingItemStatusDto[]|null getItems()
 * @method self setItems(?array $v)
 */
class ReceivingStatusDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Receivings.Dtos.ReceivingStatusDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'receivingOrder' => 'string',
        'customerCode' => 'string',
        'containerNo' => 'string',
        'carrierSCAC' => 'string',
        'bolNo' => 'string',
        'shipDate' => '\\DateTime',
        'estimatedDeliveryDate' => '\\DateTime',
        'receivingStatus' => 'string',
        'items' => '\\BeLenka\\Ship8\\Model\\ReceivingItemStatusDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'shipDate' => 'date-time',
        'estimatedDeliveryDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
