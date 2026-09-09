<?php
/**
 * ReceivingItemStatusDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Line item of ReceivingStatusDto (GET /api/app/receiving/get).
 *
 * Variance = expectedQty - receivedQty; positive is short received, negative
 * is over received.
 *
 * @method ?string getItemNo()
 * @method self setItemNo(?string $v)
 * @method ?string getItemUPC()
 * @method self setItemUPC(?string $v)
 * @method ?float getExpectedQty()
 * @method self setExpectedQty(?float $v)
 * @method ?float getReceivedQty()
 * @method self setReceivedQty(?float $v)
 * @method ?float getVarianceQty()
 * @method self setVarianceQty(?float $v)
 * @method ?string getItemStatus()
 * @method self setItemStatus(?string $v)
 */
class ReceivingItemStatusDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Receivings.Dtos.ReceivingItemStatusDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'itemNo' => 'string',
        'itemUPC' => 'string',
        'expectedQty' => 'float',
        'receivedQty' => 'float',
        'varianceQty' => 'float',
        'itemStatus' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'expectedQty' => 'double',
        'receivedQty' => 'double',
        'varianceQty' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
