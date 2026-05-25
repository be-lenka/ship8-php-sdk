<?php
/**
 * OrderCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Request body for POST /api/app/order/create.
 *
 * `shipToLevel` accepts one of: Customer, Store, DC.
 * `signatureRequired` accepts one of: SignatureRq, AdultSignatureRq, IndirectSignatureRq.
 */
class OrderCreationDto extends AbstractModel
{
    public const SHIP_TO_LEVEL_CUSTOMER = 'Customer';
    public const SHIP_TO_LEVEL_STORE = 'Store';
    public const SHIP_TO_LEVEL_DC = 'DC';

    public const SIGNATURE_REQUIRED = 'SignatureRq';
    public const SIGNATURE_ADULT_REQUIRED = 'AdultSignatureRq';
    public const SIGNATURE_INDIRECT_REQUIRED = 'IndirectSignatureRq';

    /** @var string */
    protected static $openAPIModelName = 'Order.Dtos.OrderCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'customerOrderNo' => 'string',
        'customerRetailOrderNo' => 'string',
        'customerOrderDate' => '\\DateTime',
        'requestShipDate' => '\\DateTime',
        'cancelDate' => '\\DateTime',
        'carrierSCACCode' => 'string',
        'crossDocking' => 'bool',
        'shipToLevel' => 'string',
        'businessLine' => 'string',
        'shipToCustomerName' => 'string',
        'shipToCompany' => 'string',
        'shipToAddressLine1' => 'string',
        'shipToAddressLine2' => 'string',
        'shipToCity' => 'string',
        'shipToState' => 'string',
        'shipToZipCode' => 'string',
        'shipToCountry' => 'string',
        'shipToPhone' => 'string',
        'shipToEmail' => 'string',
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
        'thirdPartyAccount' => 'string',
        'thirdPartyPostal' => 'string',
        'shippingInstructions' => 'string',
        'customerNotes' => 'string',
        'signatureRequired' => 'string',
        'orderItems' => '\\BeLenka\\Ship8\\Model\\OrderItemCreationDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'customerCode' => null,
        'customerOrderNo' => null,
        'customerRetailOrderNo' => null,
        'customerOrderDate' => 'date-time',
        'requestShipDate' => 'date-time',
        'cancelDate' => 'date-time',
        'carrierSCACCode' => null,
        'crossDocking' => null,
        'shipToLevel' => null,
        'businessLine' => null,
        'shipToCustomerName' => null,
        'shipToCompany' => null,
        'shipToAddressLine1' => null,
        'shipToAddressLine2' => null,
        'shipToCity' => null,
        'shipToState' => null,
        'shipToZipCode' => null,
        'shipToCountry' => null,
        'shipToPhone' => null,
        'shipToEmail' => 'email',
        'billToCustomerName' => null,
        'billToCompany' => null,
        'billToAddressLine1' => null,
        'billToAddressLine2' => null,
        'billToCity' => null,
        'billToState' => null,
        'billToZipCode' => null,
        'billToCountry' => null,
        'billToPhone' => null,
        'billToEmail' => 'email',
        'thirdPartyAccount' => null,
        'thirdPartyPostal' => null,
        'shippingInstructions' => null,
        'customerNotes' => null,
        'signatureRequired' => null,
        'orderItems' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'customerCode' => 'customerCode',
        'customerOrderNo' => 'customerOrderNo',
        'customerRetailOrderNo' => 'customerRetailOrderNo',
        'customerOrderDate' => 'customerOrderDate',
        'requestShipDate' => 'requestShipDate',
        'cancelDate' => 'cancelDate',
        'carrierSCACCode' => 'carrierSCACCode',
        'crossDocking' => 'crossDocking',
        'shipToLevel' => 'shipToLevel',
        'businessLine' => 'businessLine',
        'shipToCustomerName' => 'shipToCustomerName',
        'shipToCompany' => 'shipToCompany',
        'shipToAddressLine1' => 'shipToAddressLine1',
        'shipToAddressLine2' => 'shipToAddressLine2',
        'shipToCity' => 'shipToCity',
        'shipToState' => 'shipToState',
        'shipToZipCode' => 'shipToZipCode',
        'shipToCountry' => 'shipToCountry',
        'shipToPhone' => 'shipToPhone',
        'shipToEmail' => 'shipToEmail',
        'billToCustomerName' => 'billToCustomerName',
        'billToCompany' => 'billToCompany',
        'billToAddressLine1' => 'billToAddressLine1',
        'billToAddressLine2' => 'billToAddressLine2',
        'billToCity' => 'billToCity',
        'billToState' => 'billToState',
        'billToZipCode' => 'billToZipCode',
        'billToCountry' => 'billToCountry',
        'billToPhone' => 'billToPhone',
        'billToEmail' => 'billToEmail',
        'thirdPartyAccount' => 'thirdPartyAccount',
        'thirdPartyPostal' => 'thirdPartyPostal',
        'shippingInstructions' => 'shippingInstructions',
        'customerNotes' => 'customerNotes',
        'signatureRequired' => 'signatureRequired',
        'orderItems' => 'orderItems',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'customerCode' => 'setCustomerCode',
        'customerOrderNo' => 'setCustomerOrderNo',
        'customerRetailOrderNo' => 'setCustomerRetailOrderNo',
        'customerOrderDate' => 'setCustomerOrderDate',
        'requestShipDate' => 'setRequestShipDate',
        'cancelDate' => 'setCancelDate',
        'carrierSCACCode' => 'setCarrierSCACCode',
        'crossDocking' => 'setCrossDocking',
        'shipToLevel' => 'setShipToLevel',
        'businessLine' => 'setBusinessLine',
        'shipToCustomerName' => 'setShipToCustomerName',
        'shipToCompany' => 'setShipToCompany',
        'shipToAddressLine1' => 'setShipToAddressLine1',
        'shipToAddressLine2' => 'setShipToAddressLine2',
        'shipToCity' => 'setShipToCity',
        'shipToState' => 'setShipToState',
        'shipToZipCode' => 'setShipToZipCode',
        'shipToCountry' => 'setShipToCountry',
        'shipToPhone' => 'setShipToPhone',
        'shipToEmail' => 'setShipToEmail',
        'billToCustomerName' => 'setBillToCustomerName',
        'billToCompany' => 'setBillToCompany',
        'billToAddressLine1' => 'setBillToAddressLine1',
        'billToAddressLine2' => 'setBillToAddressLine2',
        'billToCity' => 'setBillToCity',
        'billToState' => 'setBillToState',
        'billToZipCode' => 'setBillToZipCode',
        'billToCountry' => 'setBillToCountry',
        'billToPhone' => 'setBillToPhone',
        'billToEmail' => 'setBillToEmail',
        'thirdPartyAccount' => 'setThirdPartyAccount',
        'thirdPartyPostal' => 'setThirdPartyPostal',
        'shippingInstructions' => 'setShippingInstructions',
        'customerNotes' => 'setCustomerNotes',
        'signatureRequired' => 'setSignatureRequired',
        'orderItems' => 'setOrderItems',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'customerCode' => 'getCustomerCode',
        'customerOrderNo' => 'getCustomerOrderNo',
        'customerRetailOrderNo' => 'getCustomerRetailOrderNo',
        'customerOrderDate' => 'getCustomerOrderDate',
        'requestShipDate' => 'getRequestShipDate',
        'cancelDate' => 'getCancelDate',
        'carrierSCACCode' => 'getCarrierSCACCode',
        'crossDocking' => 'getCrossDocking',
        'shipToLevel' => 'getShipToLevel',
        'businessLine' => 'getBusinessLine',
        'shipToCustomerName' => 'getShipToCustomerName',
        'shipToCompany' => 'getShipToCompany',
        'shipToAddressLine1' => 'getShipToAddressLine1',
        'shipToAddressLine2' => 'getShipToAddressLine2',
        'shipToCity' => 'getShipToCity',
        'shipToState' => 'getShipToState',
        'shipToZipCode' => 'getShipToZipCode',
        'shipToCountry' => 'getShipToCountry',
        'shipToPhone' => 'getShipToPhone',
        'shipToEmail' => 'getShipToEmail',
        'billToCustomerName' => 'getBillToCustomerName',
        'billToCompany' => 'getBillToCompany',
        'billToAddressLine1' => 'getBillToAddressLine1',
        'billToAddressLine2' => 'getBillToAddressLine2',
        'billToCity' => 'getBillToCity',
        'billToState' => 'getBillToState',
        'billToZipCode' => 'getBillToZipCode',
        'billToCountry' => 'getBillToCountry',
        'billToPhone' => 'getBillToPhone',
        'billToEmail' => 'getBillToEmail',
        'thirdPartyAccount' => 'getThirdPartyAccount',
        'thirdPartyPostal' => 'getThirdPartyPostal',
        'shippingInstructions' => 'getShippingInstructions',
        'customerNotes' => 'getCustomerNotes',
        'signatureRequired' => 'getSignatureRequired',
        'orderItems' => 'getOrderItems',
    ];

    public static function openAPITypes(): array
    {
        return self::$openAPITypes;
    }

    public static function openAPIFormats(): array
    {
        return self::$openAPIFormats;
    }

    public static function attributeMap(): array
    {
        return self::$attributeMap;
    }

    public static function setters(): array
    {
        return self::$setters;
    }

    public static function getters(): array
    {
        return self::$getters;
    }

    public function listInvalidProperties(): array
    {
        $errors = [];
        $required = [
            'customerCode', 'customerOrderNo', 'customerOrderDate', 'carrierSCACCode',
            'crossDocking', 'shipToLevel', 'shipToCustomerName',
            'shipToAddressLine1', 'shipToCity', 'shipToState', 'shipToZipCode',
            'shipToCountry', 'orderItems',
        ];
        foreach ($required as $field) {
            if (($this->container[$field] ?? null) === null) {
                $errors[] = "'$field' is required.";
            }
        }
        return $errors;
    }

    public function getCustomerCode(): ?string { return $this->container['customerCode']; }
    public function setCustomerCode(?string $v): self { $this->container['customerCode'] = $v; return $this; }

    public function getCustomerOrderNo(): ?string { return $this->container['customerOrderNo']; }
    public function setCustomerOrderNo(?string $v): self { $this->container['customerOrderNo'] = $v; return $this; }

    public function getCustomerRetailOrderNo(): ?string { return $this->container['customerRetailOrderNo']; }
    public function setCustomerRetailOrderNo(?string $v): self { $this->container['customerRetailOrderNo'] = $v; return $this; }

    public function getCustomerOrderDate(): ?\DateTimeInterface { return $this->container['customerOrderDate']; }
    public function setCustomerOrderDate(?\DateTimeInterface $v): self { $this->container['customerOrderDate'] = $v; return $this; }

    public function getRequestShipDate(): ?\DateTimeInterface { return $this->container['requestShipDate']; }
    public function setRequestShipDate(?\DateTimeInterface $v): self { $this->container['requestShipDate'] = $v; return $this; }

    public function getCancelDate(): ?\DateTimeInterface { return $this->container['cancelDate']; }
    public function setCancelDate(?\DateTimeInterface $v): self { $this->container['cancelDate'] = $v; return $this; }

    public function getCarrierSCACCode(): ?string { return $this->container['carrierSCACCode']; }
    public function setCarrierSCACCode(?string $v): self { $this->container['carrierSCACCode'] = $v; return $this; }

    public function getCrossDocking(): ?bool { return $this->container['crossDocking']; }
    public function setCrossDocking(?bool $v): self { $this->container['crossDocking'] = $v; return $this; }

    public function getShipToLevel(): ?string { return $this->container['shipToLevel']; }
    public function setShipToLevel(?string $v): self { $this->container['shipToLevel'] = $v; return $this; }

    public function getBusinessLine(): ?string { return $this->container['businessLine']; }
    public function setBusinessLine(?string $v): self { $this->container['businessLine'] = $v; return $this; }

    public function getShipToCustomerName(): ?string { return $this->container['shipToCustomerName']; }
    public function setShipToCustomerName(?string $v): self { $this->container['shipToCustomerName'] = $v; return $this; }

    public function getShipToCompany(): ?string { return $this->container['shipToCompany']; }
    public function setShipToCompany(?string $v): self { $this->container['shipToCompany'] = $v; return $this; }

    public function getShipToAddressLine1(): ?string { return $this->container['shipToAddressLine1']; }
    public function setShipToAddressLine1(?string $v): self { $this->container['shipToAddressLine1'] = $v; return $this; }

    public function getShipToAddressLine2(): ?string { return $this->container['shipToAddressLine2']; }
    public function setShipToAddressLine2(?string $v): self { $this->container['shipToAddressLine2'] = $v; return $this; }

    public function getShipToCity(): ?string { return $this->container['shipToCity']; }
    public function setShipToCity(?string $v): self { $this->container['shipToCity'] = $v; return $this; }

    public function getShipToState(): ?string { return $this->container['shipToState']; }
    public function setShipToState(?string $v): self { $this->container['shipToState'] = $v; return $this; }

    public function getShipToZipCode(): ?string { return $this->container['shipToZipCode']; }
    public function setShipToZipCode(?string $v): self { $this->container['shipToZipCode'] = $v; return $this; }

    public function getShipToCountry(): ?string { return $this->container['shipToCountry']; }
    public function setShipToCountry(?string $v): self { $this->container['shipToCountry'] = $v; return $this; }

    public function getShipToPhone(): ?string { return $this->container['shipToPhone']; }
    public function setShipToPhone(?string $v): self { $this->container['shipToPhone'] = $v; return $this; }

    public function getShipToEmail(): ?string { return $this->container['shipToEmail']; }
    public function setShipToEmail(?string $v): self { $this->container['shipToEmail'] = $v; return $this; }

    public function getBillToCustomerName(): ?string { return $this->container['billToCustomerName']; }
    public function setBillToCustomerName(?string $v): self { $this->container['billToCustomerName'] = $v; return $this; }

    public function getBillToCompany(): ?string { return $this->container['billToCompany']; }
    public function setBillToCompany(?string $v): self { $this->container['billToCompany'] = $v; return $this; }

    public function getBillToAddressLine1(): ?string { return $this->container['billToAddressLine1']; }
    public function setBillToAddressLine1(?string $v): self { $this->container['billToAddressLine1'] = $v; return $this; }

    public function getBillToAddressLine2(): ?string { return $this->container['billToAddressLine2']; }
    public function setBillToAddressLine2(?string $v): self { $this->container['billToAddressLine2'] = $v; return $this; }

    public function getBillToCity(): ?string { return $this->container['billToCity']; }
    public function setBillToCity(?string $v): self { $this->container['billToCity'] = $v; return $this; }

    public function getBillToState(): ?string { return $this->container['billToState']; }
    public function setBillToState(?string $v): self { $this->container['billToState'] = $v; return $this; }

    public function getBillToZipCode(): ?string { return $this->container['billToZipCode']; }
    public function setBillToZipCode(?string $v): self { $this->container['billToZipCode'] = $v; return $this; }

    public function getBillToCountry(): ?string { return $this->container['billToCountry']; }
    public function setBillToCountry(?string $v): self { $this->container['billToCountry'] = $v; return $this; }

    public function getBillToPhone(): ?string { return $this->container['billToPhone']; }
    public function setBillToPhone(?string $v): self { $this->container['billToPhone'] = $v; return $this; }

    public function getBillToEmail(): ?string { return $this->container['billToEmail']; }
    public function setBillToEmail(?string $v): self { $this->container['billToEmail'] = $v; return $this; }

    public function getThirdPartyAccount(): ?string { return $this->container['thirdPartyAccount']; }
    public function setThirdPartyAccount(?string $v): self { $this->container['thirdPartyAccount'] = $v; return $this; }

    public function getThirdPartyPostal(): ?string { return $this->container['thirdPartyPostal']; }
    public function setThirdPartyPostal(?string $v): self { $this->container['thirdPartyPostal'] = $v; return $this; }

    public function getShippingInstructions(): ?string { return $this->container['shippingInstructions']; }
    public function setShippingInstructions(?string $v): self { $this->container['shippingInstructions'] = $v; return $this; }

    public function getCustomerNotes(): ?string { return $this->container['customerNotes']; }
    public function setCustomerNotes(?string $v): self { $this->container['customerNotes'] = $v; return $this; }

    public function getSignatureRequired(): ?string { return $this->container['signatureRequired']; }
    public function setSignatureRequired(?string $v): self { $this->container['signatureRequired'] = $v; return $this; }

    /** @return OrderItemCreationDto[]|null */
    public function getOrderItems(): ?array { return $this->container['orderItems']; }

    /** @param OrderItemCreationDto[]|null $v */
    public function setOrderItems(?array $v): self { $this->container['orderItems'] = $v; return $this; }
}
