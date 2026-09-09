<?php
/**
 * ReceivingItemStatusDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Line level receiving status, nested inside the ReceivingStatusDto returned
 * by GET /api/app/receiving/get.
 *
 * Variance carries the short/over receipt signal. Its direction is easy to
 * read backwards, so here it is verbatim from the Ship8 spec:
 *
 *   Variance = ExpectedQty - ReceivedQty. Positive means short received,
 *   negative means over received.
 *
 * So `varianceQty > 0` means the warehouse received *fewer* units than the
 * receiving order expected, and `varianceQty < 0` means it received more.
 * Zero means the line reconciled exactly.
 *
 * `itemStatus` is one of Open / Received / Cancelled. Upstream declares it a
 * free-form string rather than an enum, so it is not modelled as constants.
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
