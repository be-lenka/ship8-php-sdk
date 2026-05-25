<?php
/**
 * CustomerFreightQuoteApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\EstimatedShippingCostDto;
use BeLenka\Ship8\Model\EstimatedShippingCostResultDto;

/**
 * CustomerFreightQuoteApi exposes the /api/app/customerFreightQuote endpoints.
 */
class CustomerFreightQuoteApi extends AbstractApi
{
    /**
     * POST /api/app/customerFreightQuote/getEstimatedShippingCost
     *
     * @throws ApiException
     */
    public function getEstimatedShippingCost(EstimatedShippingCostDto $request): EstimatedShippingCostResultDto
    {
        return $this->request(
            'POST',
            '/api/app/customerFreightQuote/getEstimatedShippingCost',
            [],
            [],
            $request,
            '\\BeLenka\\Ship8\\Model\\EstimatedShippingCostResultDto'
        );
    }
}
