<?php
/**
 * EstimatedShippingCostDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Request body for POST /api/app/customerFreightQuote/getEstimatedShippingCost.
 *
 * @method ?string getCustomerCode()
 * @method self setCustomerCode(?string $v)
 * @method ?string getSalesOrderNo()
 * @method self setSalesOrderNo(?string $v)
 * @method ?string getLoc()
 * @method self setLoc(?string $v)
 */
class EstimatedShippingCostDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Dtos.EstimatedShippingCostDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'customerCode' => 'string',
        'salesOrderNo' => 'string',
        'loc' => 'string',
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
        if (($this->container['salesOrderNo'] ?? null) === null) {
            $errors[] = "'salesOrderNo' is required.";
        }
        return $errors;
    }
}
