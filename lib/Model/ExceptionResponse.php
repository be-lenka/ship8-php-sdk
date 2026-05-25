<?php
/**
 * ExceptionResponse
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Server-side exception body returned for HTTP 4xx/5xx with content-type
 * application/json. Wrapped by ErrorResponse.
 */
class ExceptionResponse extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ExceptionResponse';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'code' => 'string',
        'message' => 'string',
        'details' => 'string',
        'data' => 'mixed',
        'validationErrors' => '\\BeLenka\\Ship8\\Model\\ValidationErrorResponse[]',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'code' => null,
        'message' => null,
        'details' => null,
        'data' => null,
        'validationErrors' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'code' => 'code',
        'message' => 'message',
        'details' => 'details',
        'data' => 'data',
        'validationErrors' => 'validationErrors',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'code' => 'setCode',
        'message' => 'setMessage',
        'details' => 'setDetails',
        'data' => 'setData',
        'validationErrors' => 'setValidationErrors',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'code' => 'getCode',
        'message' => 'getMessage',
        'details' => 'getDetails',
        'data' => 'getData',
        'validationErrors' => 'getValidationErrors',
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

    public function getCode(): ?string
    {
        return $this->container['code'];
    }

    public function setCode(?string $code): self
    {
        $this->container['code'] = $code;
        return $this;
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

    public function getDetails(): ?string
    {
        return $this->container['details'];
    }

    public function setDetails(?string $details): self
    {
        $this->container['details'] = $details;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->container['data'];
    }

    /**
     * @param mixed $data
     */
    public function setData($data): self
    {
        $this->container['data'] = $data;
        return $this;
    }

    /**
     * @return ValidationErrorResponse[]|null
     */
    public function getValidationErrors(): ?array
    {
        return $this->container['validationErrors'];
    }

    /**
     * @param ValidationErrorResponse[]|null $validationErrors
     */
    public function setValidationErrors(?array $validationErrors): self
    {
        $this->container['validationErrors'] = $validationErrors;
        return $this;
    }
}
