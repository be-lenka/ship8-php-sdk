<?php
/**
 * OrderItemCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Order line item for POST /api/app/order/create.
 *
 * Required: itemQty. Either itemNo or upcCode should identify the SKU.
 */
class OrderItemCreationDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Dtos.OrderItemCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'itemNo' => 'string',
        'upcCode' => 'string',
        'itemQty' => 'int',
        'unitRetailPrice' => 'float',
        'loc' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'itemNo' => null,
        'upcCode' => null,
        'itemQty' => 'int32',
        'unitRetailPrice' => 'double',
        'loc' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'itemNo' => 'itemNo',
        'upcCode' => 'upcCode',
        'itemQty' => 'itemQty',
        'unitRetailPrice' => 'unitRetailPrice',
        'loc' => 'loc',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'itemNo' => 'setItemNo',
        'upcCode' => 'setUpcCode',
        'itemQty' => 'setItemQty',
        'unitRetailPrice' => 'setUnitRetailPrice',
        'loc' => 'setLoc',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'itemNo' => 'getItemNo',
        'upcCode' => 'getUpcCode',
        'itemQty' => 'getItemQty',
        'unitRetailPrice' => 'getUnitRetailPrice',
        'loc' => 'getLoc',
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
        $qty = $this->container['itemQty'] ?? null;
        if ($qty === null) {
            $errors[] = "'itemQty' is required.";
        } elseif ($qty < 1) {
            $errors[] = "'itemQty' must be at least 1.";
        }
        $itemNo = $this->container['itemNo'] ?? null;
        $upcCode = $this->container['upcCode'] ?? null;
        if (($itemNo === null || $itemNo === '') && ($upcCode === null || $upcCode === '')) {
            $errors[] = "Either 'itemNo' or 'upcCode' is required to identify the SKU.";
        }
        return $errors;
    }

    public function getItemNo(): ?string
    {
        return $this->container['itemNo'];
    }

    public function setItemNo(?string $itemNo): self
    {
        $this->container['itemNo'] = $itemNo;
        return $this;
    }

    public function getUpcCode(): ?string
    {
        return $this->container['upcCode'];
    }

    public function setUpcCode(?string $upcCode): self
    {
        $this->container['upcCode'] = $upcCode;
        return $this;
    }

    public function getItemQty(): ?int
    {
        return $this->container['itemQty'];
    }

    public function setItemQty(?int $itemQty): self
    {
        $this->container['itemQty'] = $itemQty;
        return $this;
    }

    public function getUnitRetailPrice(): ?float
    {
        return $this->container['unitRetailPrice'];
    }

    public function setUnitRetailPrice(?float $unitRetailPrice): self
    {
        $this->container['unitRetailPrice'] = $unitRetailPrice;
        return $this;
    }

    public function getLoc(): ?string
    {
        return $this->container['loc'];
    }

    public function setLoc(?string $loc): self
    {
        $this->container['loc'] = $loc;
        return $this;
    }
}
