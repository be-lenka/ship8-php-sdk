<?php
/**
 * ValidationErrorResponse
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Per-field validation error inside an ExceptionResponse.
 */
class ValidationErrorResponse extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ValidationErrorResponse';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'message' => 'string',
        'members' => 'string[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'message' => null,
        'members' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'message' => 'message',
        'members' => 'members',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'message' => 'setMessage',
        'members' => 'setMembers',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'message' => 'getMessage',
        'members' => 'getMembers',
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

    public function getMessage(): ?string
    {
        return $this->container['message'];
    }

    public function setMessage(?string $message): self
    {
        $this->container['message'] = $message;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getMembers(): ?array
    {
        return $this->container['members'];
    }

    /**
     * @param string[]|null $members
     */
    public function setMembers(?array $members): self
    {
        $this->container['members'] = $members;
        return $this;
    }
}
