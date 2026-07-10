<?php
/**
 * ReturnOrderCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Request body for POST /api/app/returnOrder/create.
 *
 * Required: customerCode, returnOrderNo, returnDate, trackingNo, orderItems.
 */
class ReturnOrderCreationDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ReturnOrders.API.ReturnOrderCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'salesOrderNo' => 'string',
        'returnOrderNo' => 'string',
        'returnDate' => '\\DateTime',
        'trackingNo' => 'string',
        'returnLoc' => 'string',
        'orderItems' => '\\BeLenka\\Ship8\\Model\\ReturnOrderItemCreationDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'customerCode' => null,
        'salesOrderNo' => null,
        'returnOrderNo' => null,
        'returnDate' => 'date-time',
        'trackingNo' => null,
        'returnLoc' => null,
        'orderItems' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'customerCode' => 'customerCode',
        'salesOrderNo' => 'salesOrderNo',
        'returnOrderNo' => 'returnOrderNo',
        'returnDate' => 'returnDate',
        'trackingNo' => 'trackingNo',
        'returnLoc' => 'returnLoc',
        'orderItems' => 'orderItems',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'customerCode' => 'setCustomerCode',
        'salesOrderNo' => 'setSalesOrderNo',
        'returnOrderNo' => 'setReturnOrderNo',
        'returnDate' => 'setReturnDate',
        'trackingNo' => 'setTrackingNo',
        'returnLoc' => 'setReturnLoc',
        'orderItems' => 'setOrderItems',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'customerCode' => 'getCustomerCode',
        'salesOrderNo' => 'getSalesOrderNo',
        'returnOrderNo' => 'getReturnOrderNo',
        'returnDate' => 'getReturnDate',
        'trackingNo' => 'getTrackingNo',
        'returnLoc' => 'getReturnLoc',
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
            'customerCode', 'returnOrderNo', 'returnDate', 'trackingNo', 'orderItems',
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

    public function getSalesOrderNo(): ?string { return $this->container['salesOrderNo']; }
    public function setSalesOrderNo(?string $v): self { $this->container['salesOrderNo'] = $v; return $this; }

    public function getReturnOrderNo(): ?string { return $this->container['returnOrderNo']; }
    public function setReturnOrderNo(?string $v): self { $this->container['returnOrderNo'] = $v; return $this; }

    public function getReturnDate(): ?\DateTimeInterface { return $this->container['returnDate']; }
    public function setReturnDate(?\DateTimeInterface $v): self { $this->container['returnDate'] = $v; return $this; }

    public function getTrackingNo(): ?string { return $this->container['trackingNo']; }
    public function setTrackingNo(?string $v): self { $this->container['trackingNo'] = $v; return $this; }

    public function getReturnLoc(): ?string { return $this->container['returnLoc']; }
    public function setReturnLoc(?string $v): self { $this->container['returnLoc'] = $v; return $this; }

    /** @return ReturnOrderItemCreationDto[]|null */
    public function getOrderItems(): ?array { return $this->container['orderItems']; }

    /** @param ReturnOrderItemCreationDto[]|null $v */
    public function setOrderItems(?array $v): self { $this->container['orderItems'] = $v; return $this; }
}
