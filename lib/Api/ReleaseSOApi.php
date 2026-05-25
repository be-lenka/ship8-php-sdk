<?php
/**
 * ReleaseSOApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\ReleaseSOCreationDto;
use BeLenka\Ship8\Model\ReleaseSOOutDto;

/**
 * ReleaseSOApi exposes the /api/app/releaseSO endpoints — sales-order
 * releases pulled against a previously-bonded inbound PO.
 */
class ReleaseSOApi extends AbstractApi
{
    /**
     * POST /api/app/releaseSO/create
     *
     * @throws ApiException
     */
    public function create(ReleaseSOCreationDto $releaseSO): ReleaseSOOutDto
    {
        return $this->request(
            'POST',
            '/api/app/releaseSO/create',
            [],
            [],
            $releaseSO,
            '\\BeLenka\\Ship8\\Model\\ReleaseSOOutDto'
        );
    }
}
