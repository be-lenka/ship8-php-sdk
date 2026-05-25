<?php
/**
 * ReleaseSOItemCreationOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-line response payload nested inside ReleaseSOOutDto.
 *
 * @method ?int getLineNo()
 * @method self setLineNo(?int $v)
 * @method ?string getItemNo()
 * @method self setItemNo(?string $v)
 * @method ?string getItemUPC()
 * @method self setItemUPC(?string $v)
 * @method ?int getItemQty()
 * @method self setItemQty(?int $v)
 * @method ?string getEntranceID()
 * @method self setEntranceID(?string $v)
 */
class ReleaseSOItemCreationOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ReleaseSOs.API.ReleaseSOItemCreationOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'lineNo' => 'int',
        'itemNo' => 'string',
        'itemUPC' => 'string',
        'itemQty' => 'int',
        'entranceID' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'lineNo' => 'int32',
        'itemQty' => 'int32',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
