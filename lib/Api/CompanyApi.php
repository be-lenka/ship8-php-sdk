<?php
/**
 * CompanyApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;

/**
 * CompanyApi exposes the /api/app/company endpoints.
 */
class CompanyApi extends AbstractApi
{
    /**
     * GET /api/app/company/getBondedDCCompany
     *
     * The swagger response uses the un-typed ResultDto envelope (`data` is
     * unspecified). The data field is returned as a plain object/array so
     * callers can consume whatever shape the server returns.
     *
     * @return mixed
     *
     * @throws ApiException
     */
    public function getBondedDCCompany(?string $companyCode = null)
    {
        return $this->request(
            'GET',
            '/api/app/company/getBondedDCCompany',
            ['CompanyCode' => $companyCode],
            [],
            null,
            'mixed'
        );
    }
}
