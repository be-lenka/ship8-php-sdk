<?php
/**
 * AccountApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\JwtTokenRefreshRequestDto;
use BeLenka\Ship8\Model\JwtTokenResultDto;
use BeLenka\Ship8\Model\UserLoginDto;

/**
 * AccountApi exposes the /api/app/account endpoints.
 *
 * Most callers should use the higher-level `Auth` helper which wraps these
 * calls and handles persisting the resulting access token onto Configuration.
 * This API class is provided for advanced callers who want a typed, model-
 * based call against the same endpoints (and for parity with the swagger).
 */
class AccountApi extends AbstractApi
{
    /**
     * POST /api/app/account/requestToken
     *
     * @throws ApiException
     */
    public function requestToken(UserLoginDto $login): JwtTokenResultDto
    {
        return $this->request(
            'POST',
            '/api/app/account/requestToken',
            [],
            [],
            $login,
            '\\BeLenka\\Ship8\\Model\\JwtTokenResultDto'
        );
    }

    /**
     * POST /api/app/account/refreshToken
     *
     * @throws ApiException
     */
    public function refreshToken(JwtTokenRefreshRequestDto $request): JwtTokenResultDto
    {
        return $this->request(
            'POST',
            '/api/app/account/refreshToken',
            [],
            [],
            $request,
            '\\BeLenka\\Ship8\\Model\\JwtTokenResultDto'
        );
    }
}
