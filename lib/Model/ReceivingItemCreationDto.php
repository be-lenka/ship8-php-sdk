<?php
/**
 * ReceivingItemCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Line item for POST /api/app/receiving/create.
 *
 * @method ?string getItemNo()
 * @method self setItemNo(?string $v)
 * @method ?string getItemUPC()
 * @method self setItemUPC(?string $v)
 * @method ?int getItemQty()
 * @method self setItemQty(?int $v)
 * @method ?int getCasePack()
 * @method self setCasePack(?int $v)
 */
class ReceivingItemCreationDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Receivings.Dtos.ReceivingItemCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'itemNo' => 'string',
        'itemUPC' => 'string',
        'itemQty' => 'int',
        'casePack' => 'int',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'itemQty' => 'int32',
        'casePack' => 'int32',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }

    public function listInvalidProperties(): array
    {
        $errors = [];
        foreach (['itemNo', 'itemUPC', 'itemQty', 'casePack'] as $f) {
            if (($this->container[$f] ?? null) === null) {
                $errors[] = "'$f' is required.";
            }
        }
        return $errors;
    }
}
