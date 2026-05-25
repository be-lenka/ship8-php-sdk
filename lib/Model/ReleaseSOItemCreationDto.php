<?php
/**
 * ReleaseSOItemCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Line item for POST /api/app/releaseSO/create.
 *
 * @method ?string getItemNo()
 * @method self setItemNo(?string $v)
 * @method ?string getItemUPC()
 * @method self setItemUPC(?string $v)
 * @method ?int getItemQty()
 * @method self setItemQty(?int $v)
 * @method ?string getEntranceID()
 * @method self setEntranceID(?string $v)
 */
class ReleaseSOItemCreationDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ReleaseSOs.API.ReleaseSOItemCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'itemNo' => 'string',
        'itemUPC' => 'string',
        'itemQty' => 'int',
        'entranceID' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'itemQty' => 'int32',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }

    public function listInvalidProperties(): array
    {
        $errors = [];
        foreach (['itemNo', 'itemUPC', 'itemQty', 'entranceID'] as $f) {
            if (($this->container[$f] ?? null) === null) {
                $errors[] = "'$f' is required.";
            }
        }
        return $errors;
    }
}
