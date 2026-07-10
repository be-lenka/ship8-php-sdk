<?php
/**
 * ReturnOrderItemCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Return line item for POST /api/app/returnOrder/create.
 *
 * Required: itemNo, itemUpc, itemQty (both itemNo and itemUpc must identify
 * the SKU; itemQty must be at least 1).
 */
class ReturnOrderItemCreationDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ReturnOrders.API.ReturnOrderItemCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'itemNo' => 'string',
        'itemUpc' => 'string',
        'itemQty' => 'int',
        'returnReason' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'itemNo' => null,
        'itemUpc' => null,
        'itemQty' => 'int32',
        'returnReason' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'itemNo' => 'itemNo',
        'itemUpc' => 'itemUpc',
        'itemQty' => 'itemQty',
        'returnReason' => 'returnReason',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'itemNo' => 'setItemNo',
        'itemUpc' => 'setItemUpc',
        'itemQty' => 'setItemQty',
        'returnReason' => 'setReturnReason',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'itemNo' => 'getItemNo',
        'itemUpc' => 'getItemUpc',
        'itemQty' => 'getItemQty',
        'returnReason' => 'getReturnReason',
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
        $itemNo = $this->container['itemNo'] ?? null;
        if ($itemNo === null || $itemNo === '') {
            $errors[] = "'itemNo' is required.";
        }
        $itemUpc = $this->container['itemUpc'] ?? null;
        if ($itemUpc === null || $itemUpc === '') {
            $errors[] = "'itemUpc' is required.";
        }
        $qty = $this->container['itemQty'] ?? null;
        if ($qty === null) {
            $errors[] = "'itemQty' is required.";
        } elseif ($qty < 1) {
            $errors[] = "'itemQty' must be at least 1.";
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

    public function getItemUpc(): ?string
    {
        return $this->container['itemUpc'];
    }

    public function setItemUpc(?string $itemUpc): self
    {
        $this->container['itemUpc'] = $itemUpc;
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

    public function getReturnReason(): ?string
    {
        return $this->container['returnReason'];
    }

    public function setReturnReason(?string $returnReason): self
    {
        $this->container['returnReason'] = $returnReason;
        return $this;
    }
}
