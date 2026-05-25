<?php
/**
 * ProductCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Request body for POST /api/app/product/upsert.
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?bool getAutoUpdate()
 * @method self setAutoUpdate(?bool $v)
 * @method ItemCreationDto[]|null getItems()
 * @method self setItems(?array $v)
 */
class ProductCreationDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Products.Dtos.ProductCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'autoUpdate' => 'bool',
        'items' => '\\BeLenka\\Ship8\\Model\\ItemCreationDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }

    public function listInvalidProperties(): array
    {
        $errors = [];
        if (($this->container['customerCode'] ?? null) === null) {
            $errors[] = "'customerCode' is required.";
        }
        $items = $this->container['items'] ?? null;
        if ($items === null || !is_array($items) || $items === []) {
            $errors[] = "'items' must be a non-empty array.";
        }
        return $errors;
    }
}
