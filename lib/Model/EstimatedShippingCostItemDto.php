<?php
/**
 * EstimatedShippingCostItemDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-line cost detail nested inside EstimatedShippingCostResultDto.
 *
 * @method ?bool getIsFullCase()
 * @method self setIsFullCase(?bool $v)
 * @method ?int getCasePack()
 * @method self setCasePack(?int $v)
 * @method ?int getTotalCtn()
 * @method self setTotalCtn(?int $v)
 * @method ?string getCartonSize()
 * @method self setCartonSize(?string $v)
 * @method ?float getCartonCube()
 * @method self setCartonCube(?float $v)
 * @method ?float getCartonWeight()
 * @method self setCartonWeight(?float $v)
 * @method ?float getCartonRate()
 * @method self setCartonRate(?float $v)
 * @method ?float getTotalRate()
 * @method self setTotalRate(?float $v)
 */
class EstimatedShippingCostItemDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Order.Dtos.EstimatedShippingCostItemDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'isFullCase' => 'bool',
        'casePack' => 'int',
        'totalCtn' => 'int',
        'cartonSize' => 'string',
        'cartonCube' => 'float',
        'cartonWeight' => 'float',
        'cartonRate' => 'float',
        'totalRate' => 'float',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'casePack' => 'int32',
        'totalCtn' => 'int32',
        'cartonCube' => 'double',
        'cartonWeight' => 'double',
        'cartonRate' => 'double',
        'totalRate' => 'double',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
