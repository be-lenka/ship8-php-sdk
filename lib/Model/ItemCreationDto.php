<?php
/**
 * ItemCreationDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Single item entry inside ProductCreationDto. `changeType` is one of
 * `New`/`Change`. `productType` is one of `Standard`/`Assortment`/`Kit`.
 * `status` is one of `Pending`/`Active`/`Disabled`. `identifierRequired`
 * is one of `Yes`/`No`.
 *
 * @method ?string getChangeType()
 * @method self setChangeType(?string $v)
 * @method ?string getProductSKU()
 * @method self setProductSKU(?string $v)
 * @method ?string getProductDescription()
 * @method self setProductDescription(?string $v)
 * @method ?string getUpc()
 * @method self setUpc(?string $v)
 * @method ?string getProductType()
 * @method self setProductType(?string $v)
 * @method ?int getReceivingCasePack()
 * @method self setReceivingCasePack(?int $v)
 * @method ?float getLength()
 * @method self setLength(?float $v)
 * @method ?float getWidth()
 * @method self setWidth(?float $v)
 * @method ?float getHeight()
 * @method self setHeight(?float $v)
 * @method ?float getWeight()
 * @method self setWeight(?float $v)
 * @method ?int getSalesCasePack()
 * @method self setSalesCasePack(?int $v)
 * @method ?float getSalesLength()
 * @method self setSalesLength(?float $v)
 * @method ?float getSalesWidth()
 * @method self setSalesWidth(?float $v)
 * @method ?float getSalesHeight()
 * @method self setSalesHeight(?float $v)
 * @method ?float getSalesWeight()
 * @method self setSalesWeight(?float $v)
 * @method ?string getCountryOfOrigin()
 * @method self setCountryOfOrigin(?string $v)
 * @method ?string getHarmonizedCode()
 * @method self setHarmonizedCode(?string $v)
 * @method ?float getProductCost()
 * @method self setProductCost(?float $v)
 * @method ?string getStatus()
 * @method self setStatus(?string $v)
 * @method ?string getLotNo()
 * @method self setLotNo(?string $v)
 * @method ?string getSupplierNo()
 * @method self setSupplierNo(?string $v)
 * @method ?string getIdentifierRequired()
 * @method self setIdentifierRequired(?string $v)
 * @method ?int getCtnperPallet()
 * @method self setCtnperPallet(?int $v)
 */
class ItemCreationDto extends AbstractModel
{
    public const CHANGE_TYPE_NEW = 'New';
    public const CHANGE_TYPE_CHANGE = 'Change';
    public const PRODUCT_TYPE_STANDARD = 'Standard';
    public const PRODUCT_TYPE_ASSORTMENT = 'Assortment';
    public const PRODUCT_TYPE_KIT = 'Kit';
    public const STATUS_PENDING = 'Pending';
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_DISABLED = 'Disabled';
    public const IDENTIFIER_REQUIRED_YES = 'Yes';
    public const IDENTIFIER_REQUIRED_NO = 'No';

    /** @var string */
    protected static $openAPIModelName = 'Products.Dtos.ItemCreationDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'changeType' => 'string',
        'productSKU' => 'string',
        'productDescription' => 'string',
        'upc' => 'string',
        'productType' => 'string',
        'receivingCasePack' => 'int',
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
        'weight' => 'float',
        'salesCasePack' => 'int',
        'salesLength' => 'float',
        'salesWidth' => 'float',
        'salesHeight' => 'float',
        'salesWeight' => 'float',
        'countryOfOrigin' => 'string',
        'harmonizedCode' => 'string',
        'productCost' => 'float',
        'status' => 'string',
        'lotNo' => 'string',
        'supplierNo' => 'string',
        'identifierRequired' => 'string',
        'ctnperPallet' => 'int',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'receivingCasePack' => 'int32',
        'length' => 'double',
        'width' => 'double',
        'height' => 'double',
        'weight' => 'double',
        'salesCasePack' => 'int32',
        'salesLength' => 'double',
        'salesWidth' => 'double',
        'salesHeight' => 'double',
        'salesWeight' => 'double',
        'productCost' => 'double',
        'ctnperPallet' => 'int32',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }

    public function listInvalidProperties(): array
    {
        $errors = [];
        $required = ['changeType', 'productSKU', 'productDescription', 'upc',
            'productType', 'receivingCasePack', 'length', 'width', 'height',
            'weight', 'status'];
        foreach ($required as $f) {
            if (($this->container[$f] ?? null) === null) {
                $errors[] = "'$f' is required.";
            }
        }
        return $errors;
    }
}
