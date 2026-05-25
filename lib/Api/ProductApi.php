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
     * @throws ApiException
     */
    public function getInventory(): InventoryDto
    {
        return $this->request(
            'GET',
            '/api/app/product/getInventory',
            [],
            [],
            null,
            '\\BeLenka\\Ship8\\Model\\InventoryDto'
        );
    }
}
