<?php
/**
 * UserLoginDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * UserLoginDto — payload for POST /api/app/account/requestToken.
 *
 * Mirrors swagger schema `Account.UserLoginDto`. Required: email, password.
 */
class UserLoginDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'Account.UserLoginDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'email' => 'string',
        'password' => 'string',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'email' => null,
        'password' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'email' => 'email',
        'password' => 'password',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'email' => 'setEmail',
        'password' => 'setPassword',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'email' => 'getEmail',
        'password' => 'getPassword',
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
        if (($this->container['email'] ?? '') === '') {
            $errors[] = "'email' must be a non-empty string.";
        }
        if (($this->container['password'] ?? '') === '') {
            $errors[] = "'password' must be a non-empty string.";
        }
        return $errors;
    }

    public function getEmail(): ?string
    {
        return $this->container['email'];
    }

    public function setEmail(?string $email): self
    {
        $this->container['email'] = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->container['password'];
    }

    public function setPassword(?string $password): self
    {
        $this->container['password'] = $password;
        return $this;
    }
}
