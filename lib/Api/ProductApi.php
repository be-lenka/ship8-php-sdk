<?php
/**
 * ProductApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\InventoryDto;
use BeLenka\Ship8\Model\ProductCreationDto;
use BeLenka\Ship8\Model\ProductCreationOutDto;

/**
 * ProductApi exposes the /api/app/product endpoints — SKU master data
 * (upsert) and inventory snapshot (getInventory).
 */
class ProductApi extends AbstractApi
{
    /**
     * POST /api/app/product/upsert
     *
     * @throws ApiException
     */
    public function upsert(ProductCreationDto $product): ProductCreationOutDto
    {
        return $this->request(
            'POST',
            '/api/app/product/upsert',
            [],
            [],
            $product,
            '\\BeLenka\\Ship8\\Model\\ProductCreationOutDto'
        );
    }

    /**
     * GET /api/app/product/getInventory
     *
     * Both filters are optional; pass null to omit. With no arguments this
     * returns the full inventory snapshot.
     *
     * @throws ApiException
     */
    public function getInventory(?string $itemNo = null, ?string $upc = null): InventoryDto
    {
        // Query keys are PascalCase per resources/swagger.json (ItemNo/UPC). Note this
        // differs from /order/get and /receiving/get, which use camelCase.
        // buildQuery strips nulls, but NOT empty strings.
        return $this->request(
            'GET',
            '/api/app/product/getInventory',
            ['ItemNo' => $itemNo, 'UPC' => $upc],
            [],
            null,
            '\\BeLenka\\Ship8\\Model\\InventoryDto'
        );
    }
}
