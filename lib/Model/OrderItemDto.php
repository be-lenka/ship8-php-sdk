<?php
/**
 * OrderItemDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Order line item returned by /api/app/order/get.
 */
class OrderItemDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Dtos.OrderItemDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'lineNo' => 'int',
        'sku' => 'string',
        'upc' => 'string',
        'productName' => 'string',
        'qtyOrdered' => 'float',
        'status' => 'string',
        'unitRetailPrice' => 'float',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'lineNo' => 'int32',
        'sku' => null,
        'upc' => null,
        'productName' => null,
        'qtyOrdered' => 'double',
        'status' => null,
        'unitRetailPrice' => 'double',
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'lineNo' => 'lineNo',
        'sku' => 'sku',
        'upc' => 'upc',
        'productName' => 'productName',
        'qtyOrdered' => 'qtyOrdered',
        'status' => 'status',
        'unitRetailPrice' => 'unitRetailPrice',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'lineNo' => 'setLineNo',
        'sku' => 'setSku',
        'upc' => 'setUpc',
        'productName' => 'setProductName',
        'qtyOrdered' => 'setQtyOrdered',
        'status' => 'setStatus',
        'unitRetailPrice' => 'setUnitRetailPrice',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'lineNo' => 'getLineNo',
        'sku' => 'getSku',
        'upc' => 'getUpc',
        'productName' => 'getProductName',
        'qtyOrdered' => 'getQtyOrdered',
        'status' => 'getStatus',
        'unitRetailPrice' => 'getUnitRetailPrice',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
    public static function attributeMap(): array { return self::$attributeMap; }
    public static function setters(): array { return self::$setters; }
    public static function getters(): array { return self::$getters; }

    public function getLineNo(): ?int { return $this->container['lineNo']; }
    public function setLineNo(?int $v): self { $this->container['lineNo'] = $v; return $this; }
    public function getSku(): ?string { return $this->container['sku']; }
    public function setSku(?string $v): self { $this->container['sku'] = $v; return $this; }
    public function getUpc(): ?string { return $this->container['upc']; }
    public function setUpc(?string $v): self { $this->container['upc'] = $v; return $this; }
    public function getProductName(): ?string { return $this->container['productName']; }
    public function setProductName(?string $v): self { $this->container['productName'] = $v; return $this; }
    public function getQtyOrdered(): ?float { return $this->container['qtyOrdered']; }
    public function setQtyOrdered(?float $v): self { $this->container['qtyOrdered'] = $v; return $this; }
    public function getStatus(): ?string { return $this->container['status']; }
    public function setStatus(?string $v): self { $this->container['status'] = $v; return $this; }
    public function getUnitRetailPrice(): ?float { return $this->container['unitRetailPrice']; }
    public function setUnitRetailPrice(?float $v): self { $this->container['unitRetailPrice'] = $v; return $this; }
}
