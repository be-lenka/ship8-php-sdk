<?php
/**
 * ItemCreationOutDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-item response payload nested inside ProductCreationOutDto.
 *
 * @method ?string getId()
 * @method self setId(?string $v)
 * @method ?string getProductSKU()
 * @method self setProductSKU(?string $v)
 * @method ?string getProductDescription()
 * @method self setProductDescription(?string $v)
 * @method ?string getUpc()
 * @method self setUpc(?string $v)
 * @method ?int getProductType()
 * @method self setProductType(?int $v)
 * @method ?string getProductTypeName()
 * @method self setProductTypeName(?string $v)
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
 * @method ?float getUnitWeight()
 * @method self setUnitWeight(?float $v)
 * @method ?int getSellingCasePack()
 * @method self setSellingCasePack(?int $v)
 * @method ?float getSalesLength()
 * @method self setSalesLength(?float $v)
 * @method ?float getSalesWidth()
 * @method self setSalesWidth(?float $v)
 * @method ?float getSalesHeight()
 * @method self setSalesHeight(?float $v)
 * @method ?float getSalesWeight()
 * @method self setSalesWeight(?float $v)
 * @method ?float getSalesUnitWeight()
 * @method self setSalesUnitWeight(?float $v)
 * @method ?int getLiftType()
 * @method self setLiftType(?int $v)
 * @method ?string getLiftTypeName()
 * @method self setLiftTypeName(?string $v)
 * @method ?string getCountryCode()
 * @method self setCountryCode(?string $v)
 * @method ?string getCountryName()
 * @method self setCountryName(?string $v)
 * @method ?string getHarmonizedCode()
 * @method self setHarmonizedCode(?string $v)
 * @method ?float getProductCost()
 * @method self setProductCost(?float $v)
 * @method ?string getLotNo()
 * @method self setLotNo(?string $v)
 * @method ?string getSupplierNo()
 * @method self setSupplierNo(?string $v)
 * @method ?int getStatus()
 * @method self setStatus(?int $v)
 * @method ?string getStatusName()
 * @method self setStatusName(?string $v)
 * @method ?int getIdentifierRequired()
 * @method self setIdentifierRequired(?int $v)
 * @method ?string getIdentifierRequiredText()
 * @method self setIdentifierRequiredText(?string $v)
 * @method ?\DateTimeInterface getCreatedDate()
 * @method self setCreatedDate(?\DateTimeInterface $v)
 * @method ?string getCreatedBy()
 * @method self setCreatedBy(?string $v)
 * @method ?\DateTimeInterface getLastUpdatedDate()
 * @method self setLastUpdatedDate(?\DateTimeInterface $v)
 * @method ?string getLastUpdatedBy()
 * @method self setLastUpdatedBy(?string $v)
 */
class ItemCreationOutDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Products.Dtos.ItemCreationOutDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'id' => 'string',
        'productSKU' => 'string',
        'productDescription' => 'string',
        'upc' => 'string',
        'productType' => 'int',
        'productTypeName' => 'string',
        'receivingCasePack' => 'int',
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
        'weight' => 'float',
        'unitWeight' => 'float',
        'sellingCasePack' => 'int',
        'salesLength' => 'float',
        'salesWidth' => 'float',
        'salesHeight' => 'float',
        'salesWeight' => 'float',
        'salesUnitWeight' => 'float',
        'liftType' => 'int',
        'liftTypeName' => 'string',
        'countryCode' => 'string',
        'countryName' => 'string',
        'harmonizedCode' => 'string',
        'productCost' => 'float',
        'lotNo' => 'string',
        'supplierNo' => 'string',
        'status' => 'int',
        'statusName' => 'string',
        'identifierRequired' => 'int',
        'identifierRequiredText' => 'string',
        'createdDate' => '\\DateTime',
        'createdBy' => 'string',
        'lastUpdatedDate' => '\\DateTime',
        'lastUpdatedBy' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'id' => 'uuid',
        'productType' => 'int32',
        'receivingCasePack' => 'int32',
        'length' => 'double',
        'width' => 'double',
        'height' => 'double',
        'weight' => 'double',
        'unitWeight' => 'double',
        'sellingCasePack' => 'int32',
        'salesLength' => 'double',
        'salesWidth' => 'double',
        'salesHeight' => 'double',
        'salesWeight' => 'double',
        'salesUnitWeight' => 'double',
        'liftType' => 'int32',
        'productCost' => 'double',
        'status' => 'int32',
        'identifierRequired' => 'int32',
        'createdDate' => 'date-time',
        'lastUpdatedDate' => 'date-time',
    ];

    public static function openAPITypes(): array { return self::$openAPITypes; }
    public static function openAPIFormats(): array { return self::$openAPIFormats; }
}
