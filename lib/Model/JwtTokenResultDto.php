<?php
/**
 * JwtTokenResultDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Response payload (`data`) from /api/app/account/requestToken and
 * /api/app/account/refreshToken.
 */
class JwtTokenResultDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Account.JwtTokenResultDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'accessToken' => 'string',
        'accessTokenExpireAt' => '\\DateTime',
        'refreshToken' => '\\BeLenka\\Ship8\\Model\\JwtRefreshTokenDto',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'accessToken' => null,
        'accessTokenExpireAt' => 'date-time',
        'refreshToken' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'accessToken' => 'accessToken',
        'accessTokenExpireAt' => 'accessTokenExpireAt',
        'refreshToken' => 'refreshToken',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'accessToken' => 'setAccessToken',
        'accessTokenExpireAt' => 'setAccessTokenExpireAt',
        'refreshToken' => 'setRefreshToken',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'accessToken' => 'getAccessToken',
        'accessTokenExpireAt' => 'getAccessTokenExpireAt',
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

    public function getAccessToken(): ?string
    {
        return $this->container['accessToken'];
    }

    public function setAccessToken(?string $accessToken): self
    {
        $this->container['accessToken'] = $accessToken;
        return $this;
    }

    public function getAccessTokenExpireAt(): ?\DateTimeInterface
    {
        return $this->container['accessTokenExpireAt'];
    }

    public function setAccessTokenExpireAt(?\DateTimeInterface $expireAt): self
    {
        $this->container['accessTokenExpireAt'] = $expireAt;
        return $this;
    }

    public function getRefreshToken(): ?JwtRefreshTokenDto
    {
        return $this->container['refreshToken'];
    }

    public function setRefreshToken(?JwtRefreshTokenDto $refreshToken): self
    {
        $this->container['refreshToken'] = $refreshToken;
        return $this;
    }
}
