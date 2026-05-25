<?php
/**
 * EstimatedShippingCostResultDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload from POST /api/app/customerFreightQuote/getEstimatedShippingCost.
 *
 * @method ?string getSalesOrderNo()
 * @method self setSalesOrderNo(?string $v)
 * @method ?string getShipMethod()
 * @method self setShipMethod(?string $v)
 * @method ?string getFromAddress()
 * @method self setFromAddress(?string $v)
 * @method ?string getToAddress()
 * @method self setToAddress(?string $v)
 * @method ?float getTotalCost()
 * @method self setTotalCost(?float $v)
 * @method EstimatedShippingCostItemDto[]|null getItemDetail()
 * @method self setItemDetail(?array $v)
 */
class EstimatedShippingCostResultDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Dtos.EstimatedShippingCostResultDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'salesOrderNo' => 'string',
        'shipMethod' => 'string',
        'fromAddress' => 'string',
        'toAddress' => 'string',
        'totalCost' => 'float',
        'itemDetail' => '\\BeLenka\\Ship8\\Model\\EstimatedShippingCostItemDto[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'totalCost' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
