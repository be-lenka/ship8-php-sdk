<?php
/**
 * ErrorResponse
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Outer error envelope returned for non-2xx responses with JSON bodies.
 */
class ErrorResponse extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ErrorResponse';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'error' => '\\BeLenka\\Ship8\\Model\\ExceptionResponse',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'error' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'error' => 'error',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'error' => 'setError',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'error' => 'getError',
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

    public function getError(): ?ExceptionResponse
    {
        return $this->container['error'];
    }

    public function setError(?ExceptionResponse $error): self
    {
        $this->container['error'] = $error;
        return $this;
    }
}
