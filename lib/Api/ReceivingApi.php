<?php
/**
 * ReceivingApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\ReceivingCreationDto;
use BeLenka\Ship8\Model\ReceivingOutDto;
use BeLenka\Ship8\Model\ReceivingStatusDto;

/**
 * ReceivingApi exposes the /api/app/receiving endpoints.
 */
class ReceivingApi extends AbstractApi
{
    /**
     * POST /api/app/receiving/create
     *
     * @throws ApiException
     */
    public function create(ReceivingCreationDto $receiving): ReceivingOutDto
    {
        return $this->request(
            'POST',
            '/api/app/receiving/create',
            [],
            [],
            $receiving,
            '\\BeLenka\\Ship8\\Model\\ReceivingOutDto'
        );
    }

    /**
     * GET /api/app/receiving/get — receiving order status.
     *
     * Returns ReceivingStatusDto (header identifiers + line level
     * expected/received/variance), NOT the wider ReceivingOutDto that create()
     * returns.
     *
     * @throws ApiException
     */
    public function getStatus(string $customerCode, string $receivingOrder): ReceivingStatusDto
    {
        // Query keys are camelCase per resources/swagger.json — same as /order/get.
        // Note this differs from /shipment/get and /product/getInventory, which
        // use PascalCase.
        return $this->request(
            'GET',
            '/api/app/receiving/get',
            ['customerCode' => $customerCode, 'receivingOrder' => $receivingOrder],
            [],
            null,
            '\\BeLenka\\Ship8\\Model\\ReceivingStatusDto'
        );
    }
}
