<?php
/**
 * InboundPOCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Request body for POST /api/app/inboundPO/create and the EEC variant.
 * Most string fields are required (see swagger Inbound POs.InboundPOCreationDto).
 *
 * @method ?string getEecShipmentID()
 * @method self setEecShipmentID(?string $v)
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getInboundPO()
 * @method self setInboundPO(?string $v)
 * @method ?string getEntranceDocumentID()
 * @method self setEntranceDocumentID(?string $v)
 * @method ?string getContainerNo()
 * @method self setContainerNo(?string $v)
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
 * @method ?string getComment()
 * @method self setComment(?string $v)
 * @method ?string getUserEmail()
 * @method self setUserEmail(?string $v)
 * @method ?string getEecMasterPO_ID()
 * @method self setEecMasterPO_ID(?string $v)
 * @method InboundPOItemCreationDto[]|null getOrderItems()
 * @method self setOrderItems(?array $v)
 */
class InboundPOCreationDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'InboundPOs.InboundPOCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'eecShipmentID' => 'string',
        'customerCode' => 'string',
        'inboundPO' => 'string',
        'entranceDocumentID' => 'string',
        'containerNo' => 'string',
        'carrierSCAC' => 'string',
        'bolNo' => 'string',
        'shipToCode' => 'string',
        'shipDate' => '\\DateTime',
        'sealNo' => 'string',
        'comment' => 'string',
        'userEmail' => 'string',
        'eecMasterPO_ID' => 'string',
        'orderItems' => '\\BeLenka\\Ship8\\Model\\InboundPOItemCreationDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'shipDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }

    public function listInvalidProperties(): array
    {
        $errors = [];
        $required = ['customerCode', 'inboundPO', 'containerNo', 'carrierSCAC',
            'bolNo', 'shipToCode', 'shipDate', 'sealNo', 'orderItems'];
        foreach ($required as $f) {
            if (($this->container[$f] ?? null) === null) {
                $errors[] = "'$f' is required.";
            }
        }
        return $errors;
    }
}
