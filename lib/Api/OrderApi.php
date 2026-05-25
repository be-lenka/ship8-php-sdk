<?php
/**
 * OrderApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\OrderCreationDto;
use BeLenka\Ship8\Model\OrderOutDto;

/**
 * OrderApi exposes the /api/app/order endpoints — outbound customer orders.
 */
class OrderApi extends AbstractApi
{
    /**
     * POST /api/app/order/create
     *
     * @throws ApiException
     */
    public function create(OrderCreationDto $order): OrderOutDto
    {
        return $this->request(
            'POST',
            '/api/app/order/create',
            [],
            [],
            $order,
            '\\BeLenka\\Ship8\\Model\\OrderOutDto'
        );
    }

    /**
     * GET /api/app/order/get
     *
     * Returns the order matching the customerCode + orderNo pair.
     *
     * @throws ApiException
     */
    public function get(string $customerCode, string $orderNo): OrderOutDto
    {
        // Query keys are camelCase per resources/swagger.json. Note this differs from
        // /shipment/get, which uses PascalCase (CustomerCode/CustomerOrderNo).
        return $this->request(
            'GET',
            '/api/app/order/get',
            ['customerCode' => $customerCode, 'orderNo' => $orderNo],
            [],
            null,
            '\\BeLenka\\Ship8\\Model\\OrderOutDto'
        );
    }
}
