<?php
/**
 * ResultDto
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

/**
 * Generic Ship8 envelope wrapping every business response. Most callers
 * never see this type because AbstractApi unwraps `data` on success and
 * raises ApiException on `successful=false`. It is exposed for
 * advanced cases that pass `unwrapResult=false` to AbstractApi::request.
 */
class ResultDto extends AbstractModel
{
    /** @var string */
    protected static $openAPIModelName = 'ResultDto';

    /** @var array<string, string> */
    protected static $openAPITypes = [
        'successful' => 'bool',
        'code' => 'string',
        'message' => 'string',
        'data' => 'mixed',
    ];

    /** @var array<string, string|null> */
    protected static $openAPIFormats = [
        'successful' => null,
        'code' => null,
        'message' => null,
        'data' => null,
    ];

    /** @var array<string, string> */
    protected static $attributeMap = [
        'successful' => 'successful',
        'code' => 'code',
        'message' => 'message',
        'data' => 'data',
    ];

    /** @var array<string, string> */
    protected static $setters = [
        'successful' => 'setSuccessful',
        'code' => 'setCode',
        'message' => 'setMessage',
        'data' => 'setData',
    ];

    /** @var array<string, string> */
    protected static $getters = [
        'successful' => 'getSuccessful',
        'code' => 'getCode',
        'message' => 'getMessage',
        'data' => 'getData',
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

    public function getSuccessful(): ?bool
    {
        return $this->container['successful'];
    }

    public function setSuccessful(?bool $successful): self
    {
        $this->container['successful'] = $successful;
        return $this;
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
}
