<?php
/**
 * InboundPOOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from POST /api/app/inboundPO/create (and EEC variant).
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getId()
 * @method self setId(?string $v)
 * @method ?string getInboundPO()
 * @method self setInboundPO(?string $v)
 * @method ?string getEntranceDocumentID()
 * @method self setEntranceDocumentID(?string $v)
 * @method ?string getContainerNo()
 * @method self setContainerNo(?string $v)
 * @method ?string getCarrier()
 * @method self setCarrier(?string $v)
 * @method ?string getCarrierSCAC()
 * @method self setCarrierSCAC(?string $v)
 * @method ?string getBolNo()
 * @method self setBolNo(?string $v)
 * @method ?string getShipToCode()
 * @method self setShipToCode(?string $v)
 * @method ?\DateTimeInterface getShipDate()
 * @method self setShipDate(?\DateTimeInterface $v)
 * @method ?string getSealNo()
 * @method self setSealNo(?string $v)
 * @method ?string getStatus()
 * @method self setStatus(?string $v)
 * @method ?string getComment()
 * @method self setComment(?string $v)
 * @method InboundPOLineItemOutDto[]|null getOrderItems()
 * @method self setOrderItems(?array $v)
 */
class InboundPOOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'InboundPOs.InboundPOOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'id' => 'string',
        'inboundPO' => 'string',
        'entranceDocumentID' => 'string',
        'containerNo' => 'string',
        'carrier' => 'string',
        'carrierSCAC' => 'string',
        'bolNo' => 'string',
        'shipToCode' => 'string',
        'shipDate' => '\\DateTime',
        'sealNo' => 'string',
        'status' => 'string',
        'comment' => 'string',
        'orderItems' => '\\BeLenka\\Ship8\\Model\\InboundPOLineItemOutDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'id' => 'uuid',
        'shipDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
