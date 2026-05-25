<?php
/**
 * ShipmentApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\ShipmentDto;

/**
 * ShipmentApi exposes the /api/app/shipment endpoints.
 */
class ShipmentApi extends AbstractApi
{
    /**
     * GET /api/app/shipment/get — list shipments for an order.
     *
     * @return ShipmentDto[]
     *
     * @throws ApiException
     */
    public function get(string $customerCode, string $customerOrderNo): array
    {
        // Query keys are PascalCase per resources/swagger.json. Note this differs from
        // /order/get, which uses camelCase (customerCode/orderNo).
        $response = $this->request(
            'GET',
            '/api/app/shipment/get',
            ['CustomerCode' => $customerCode, 'CustomerOrderNo' => $customerOrderNo],
            [],
            null,
            '\\BeLenka\\Ship8\\Model\\ShipmentDto[]'
        );
        return $response ?? [];
    }
}
