<?php
/**
 * AbstractModel
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

namespace BeLenka\Ship8\Model;

use ArrayAccess;
use BadMethodCallException;
use JsonSerializable;

/**
 * AbstractModel provides the generic property bag + ArrayAccess + JSON
 * serialization that every concrete Ship8 model needs.
 *
 * Subclasses minimally declare:
 *   - protected static $openAPIModelName  — the swagger schema name
 *   - protected static $openAPITypes      — property => OpenAPI type
 *   - protected static $openAPIFormats    — property => OpenAPI format
 *
 * The attribute / setter / getter maps default to identity/derived values
 * (camelCase names) — subclasses only override them when the wire name or
 * accessor name should diverge from the property name. Generic getXxx /
 * setXxx accessors are provided through __call against $openAPITypes.
 *
 * @implements ArrayAccess<string, mixed>
 */
abstract class AbstractModel implements ModelInterface, ArrayAccess, JsonSerializable
{
    /** @var array<string, mixed> */
    protected $container = [];

    /**
     * Per-class auto-derived map cache so attributeMap()/setters()/getters()
     * don't recompute on every call.
     *
     * @var array<class-string, array{attributeMap: array<string, string>, setters: array<string, string>, getters: array<string, string>}>
     */
    private static $derivedMaps = [];

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        foreach (static::attributeMap() as $property => $_) {
            $this->container[$property] = $data[$property] ?? null;
        }
    }

    public function getModelName(): string
    {
        return static::$openAPIModelName ?? (new \ReflectionClass($this))->getShortName();
    }

    public function listInvalidProperties(): array
    {
        return [];
    }

    public function valid(): bool
    {
        return $this->listInvalidProperties() === [];
    }

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return \BeLenka\Ship8\ObjectSerializer::sanitizeForSerialization($this);
    }

    public function __toString(): string
    {
        return (string) json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }

    public static function openAPINullables(): array
    {
        return [];
    }

    /**
     * Default attribute map: identity mapping derived from $openAPITypes.
     * Subclasses override only when wire name differs from the property name.
     *
     * @return array<string, string>
     */
    public static function attributeMap(): array
    {
        return self::deriveMaps()[static::class]['attributeMap'];
    }

    /**
     * @return array<string, string>
     */
    public static function setters(): array
    {
        return self::deriveMaps()[static::class]['setters'];
    }

    /**
     * @return array<string, string>
     */
    public static function getters(): array
    {
        return self::deriveMaps()[static::class]['getters'];
    }

    public static function openAPIFormats(): array
    {
        return [];
    }

    /**
     * Compute and cache the derived attribute / setter / getter maps for the
     * concrete subclass. The maps default to identity / set<Property> /
     * get<Property> and can always be replaced by overriding the static
     * methods on the subclass.
     *
     * @return array<class-string, array{attributeMap: array<string, string>, setters: array<string, string>, getters: array<string, string>}>
     */
    private static function deriveMaps(): array
    {
        $class = static::class;
        if (isset(self::$derivedMaps[$class])) {
            return self::$derivedMaps;
        }
        $types = static::openAPITypes();
        $attributeMap = [];
        $setters = [];
        $getters = [];
        foreach (array_keys($types) as $property) {
            $attributeMap[$property] = $property;
            $setters[$property] = 'set' . ucfirst($property);
            $getters[$property] = 'get' . ucfirst($property);
        }
        self::$derivedMaps[$class] = [
            'attributeMap' => $attributeMap,
            'setters' => $setters,
            'getters' => $getters,
        ];
        return self::$derivedMaps;
    }

    /**
     * Generic getXxx/setXxx dispatch driven by $openAPITypes — saves a lot
     * of boilerplate on output DTOs. Subclasses can still declare explicit
     * methods (e.g. with stricter type hints) and they will take priority
     * over this fallback.
     *
     * @param array<int, mixed> $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (strlen($name) > 3) {
            $prefix = substr($name, 0, 3);
            if ($prefix === 'get' || $prefix === 'set') {
                $property = lcfirst(substr($name, 3));
                if (array_key_exists($property, static::openAPITypes())) {
                    if ($prefix === 'get') {
                        return $this->container[$property] ?? null;
                    }
                    $this->container[$property] = $arguments[0] ?? null;
                    return $this;
                }
            }
        }
        throw new BadMethodCallException(sprintf('Unknown method %s::%s', static::class, $name));
    }
}
