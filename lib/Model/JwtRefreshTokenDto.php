<?php
/**
 * JwtRefreshTokenDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Refresh-token sub-structure of `Account.JwtTokenResultDto`. Carries the
 * actual refresh-token string plus its owner email and expiry.
 */
class JwtRefreshTokenDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Account.JwtRefreshTokenDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'userName' => 'string',
        'tokenString' => 'string',
        'expireAt' => '\\DateTime',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'userName' => null,
        'tokenString' => null,
        'expireAt' => 'date-time',
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'userName' => 'userName',
        'tokenString' => 'tokenString',
        'expireAt' => 'expireAt',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'userName' => 'setUserName',
        'tokenString' => 'setTokenString',
        'expireAt' => 'setExpireAt',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'userName' => 'getUserName',
        'tokenString' => 'getTokenString',
        'expireAt' => 'getExpireAt',
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

    public function getUserName(): ?string
    {
        return $this->container['userName'];
    }

    public function setUserName(?string $userName): self
    {
        $this->container['userName'] = $userName;
        return $this;
    }

    public function getTokenString(): ?string
    {
        return $this->container['tokenString'];
    }

    public function setTokenString(?string $tokenString): self
    {
        $this->container['tokenString'] = $tokenString;
        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->container['expireAt'];
    }

    public function setExpireAt(?\DateTimeInterface $expireAt): self
    {
        $this->container['expireAt'] = $expireAt;
        return $this;
    }
}
