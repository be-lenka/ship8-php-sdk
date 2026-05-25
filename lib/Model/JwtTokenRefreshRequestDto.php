<?php
/**
 * JwtTokenRefreshRequestDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Request body for POST /api/app/account/refreshToken — the caller must
 * present the *expired* access token alongside the refresh-token string
 * issued in the original requestToken response.
 */
class JwtTokenRefreshRequestDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Account.JwtTokenRefreshRequestDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'accessToken' => 'string',
        'refreshToken' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'accessToken' => null,
        'refreshToken' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'accessToken' => 'accessToken',
        'refreshToken' => 'refreshToken',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'accessToken' => 'setAccessToken',
        'refreshToken' => 'setRefreshToken',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'accessToken' => 'getAccessToken',
        'refreshToken' => 'getRefreshToken',
    ];

    public static function openAPITypes(): array
    {
        return self::$openAPITypes;
    }

    public static function openAPIFormats(): array
    {
        return self::$openAPIFormats;
    }

    public static function attributeMap(): array
    {
        return self::$attributeMap;
    }

    public static function setters(): array
    {
        return self::$setters;
    }

    public static function getters(): array
    {
        return self::$getters;
    }

    public function listInvalidProperties(): array
    {
        $errors = [];
        if (($this->container['accessToken'] ?? '') === '') {
            $errors[] = "'accessToken' must be a non-empty string.";
        }
        if (($this->container['refreshToken'] ?? '') === '') {
            $errors[] = "'refreshToken' must be a non-empty string.";
        }
        return $errors;
    }

    public function getAccessToken(): ?string
    {
        return $this->container['accessToken'];
    }

    public function setAccessToken(?string $accessToken): self
    {
        $this->container['accessToken'] = $accessToken;
        return $this;
    }

    public function getRefreshToken(): ?string
    {
        return $this->container['refreshToken'];
    }

    public function setRefreshToken(?string $refreshToken): self
    {
        $this->container['refreshToken'] = $refreshToken;
        return $this;
    }
}
