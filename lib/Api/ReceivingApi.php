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
}
