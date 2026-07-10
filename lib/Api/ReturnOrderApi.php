<?php
/**
 * ReturnOrderApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\ReturnOrderCreationDto;
use BeLenka\Ship8\Model\ReturnOrderOutDto;

/**
 * ReturnOrderApi exposes the /api/app/returnOrder endpoints — customer
 * return orders logged against a previously-shipped sales order.
 */
class ReturnOrderApi extends AbstractApi
{
    /**
     * POST /api/app/returnOrder/create
     *
     * @throws ApiException
     */
    public function create(ReturnOrderCreationDto $returnOrder): ReturnOrderOutDto
    {
        return $this->request(
            'POST',
            '/api/app/returnOrder/create',
            [],
            [],
            $returnOrder,
            '\\BeLenka\\Ship8\\Model\\ReturnOrderOutDto'
        );
    }
}
