<?php
/**
 * ObjectSerializer
 *
 * @category Class
 * @package  BeLenka\Ship8
 */

namespace BeLenka\Ship8;

use BeLenka\Ship8\Model\ModelInterface;

/**
 * ObjectSerializer converts SDK models <-> primitives suitable for JSON
 * transport, plus helpers for query-string and path serialization.
 *
 * @category Class
 * @package  BeLenka\Ship8
 */
class ObjectSerializer
{
    /** @var string */
    private static $dateTimeFormat = \DateTime::ATOM;

    public static function setDateTimeFormat(string $format): void
    {
        self::$dateTimeFormat = $format;
    }

    /**
     * Recursively turn a value (model, array, scalar, DateTime) into a
     * JSON-encodable primitive.
     *
     * @param mixed       $data
     * @param string|null $type   OpenAPI type hint (currently unused, reserved for future enum validation)
     * @param string|null $format OpenAPI format (e.g. "date" vs "date-time")
     *
     * @return mixed
     */
    public static function sanitizeForSerialization($data, ?string $type = null, ?string $format = null)
    {
        if (is_scalar($data) || $data === null) {
            return $data;
        }

        if ($data instanceof \DateTimeInterface) {
            return $format === 'date' ? $data->format('Y-m-d') : $data->format(self::$dateTimeFormat);
        }

        if (is_array($data)) {
            $out = [];
            foreach ($data as $k => $v) {
                $out[$k] = self::sanitizeForSerialization($v);
            }
            return $out;
        }

        if ($data instanceof ModelInterface) {
            $values = [];
            foreach ($data::openAPITypes() as $property => $openAPIType) {
                $getter = $data::getters()[$property] ?? null;
                if ($getter === null) {
                    continue;
                }
                $value = $data->$getter();
                if ($value === null && !in_array($property, $data::openAPINullables() ? array_keys(array_filter($data::openAPINullables())) : [], true)) {
                    continue;
                }
                $apiName = $data::attributeMap()[$property] ?? $property;
                $values[$apiName] = self::sanitizeForSerialization($value);
            }
            return (object) $values;
        }

        if (is_object($data)) {
            return (object) array_map([self::class, 'sanitizeForSerialization'], (array) $data);
        }

        return (string) $data;
    }

    /**
     * Sanitize a path segment.
     */
    public static function toPathValue(string $value): string
    {
        return rawurlencode((string) self::toString($value));
    }

    /**
     * Sanitize a query value, expanding arrays into comma-joined form
     * (RFC 3986 form, OpenAPI `style=form,explode=false`).
     *
     * @param mixed $object
     */
    public static function toQueryValue($object): string
    {
        if (is_array($object)) {
            return implode(',', array_map([self::class, 'toString'], $object));
        }
        return self::toString($object);
    }

    /**
     * @param mixed $value
     */
    public static function toString($value): string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format(self::$dateTimeFormat);
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        return (string) $value;
    }

    /**
     * Build a query string from an associative array, dropping null entries.
     *
     * @param array<string, mixed> $params
     */
    public static function buildQuery(array $params): string
    {
        $cleaned = array_filter(
            $params,
            static fn($v) => $v !== null
        );
        if ($cleaned === []) {
            return '';
        }
        $pairs = [];
        foreach ($cleaned as $k => $v) {
            $pairs[$k] = self::toQueryValue($v);
        }
        return http_build_query($pairs, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * Deserialize a JSON-decoded payload into a model / scalar / array.
     *
     * @param mixed                $data
     * @param string               $class      Target type (e.g. "string", "int",
     *                                         "\\DateTime", "Foo[]", or a model FQCN)
     * @param array<string,string> $httpHeaders
     *
     * @return mixed
     */
    public static function deserialize($data, string $class, array $httpHeaders = [])
    {
        if ($data === null) {
            return null;
        }

        if (substr($class, -2) === '[]') {
            $itemClass = substr($class, 0, -2);
            $items = [];
            foreach ((array) $data as $k => $v) {
                $items[$k] = self::deserialize($v, $itemClass, $httpHeaders);
            }
            return $items;
        }

        if (in_array($class, ['string', 'int', 'integer', 'float', 'double', 'bool', 'boolean'], true)) {
            settype($data, $class);
            return $data;
        }

        if ($class === '\DateTime' || $class === 'DateTime') {
            if (is_string($data) && $data !== '') {
                return new \DateTime($data);
            }
            return null;
        }

        if ($class === 'object' || $class === 'mixed' || $class === '') {
            return $data;
        }

        if (is_subclass_of($class, ModelInterface::class)) {
            $payload = is_object($data) ? get_object_vars($data) : (array) $data;
            $instance = new $class();
            $types = $class::openAPITypes();
            $attributeMap = $class::attributeMap();
            $setters = $class::setters();
            foreach ($attributeMap as $property => $apiName) {
                if (!array_key_exists($apiName, $payload)) {
                    continue;
                }
                $setter = $setters[$property] ?? null;
                if ($setter === null) {
                    continue;
                }
                $value = self::deserialize($payload[$apiName], $types[$property] ?? 'mixed', $httpHeaders);
                $instance->$setter($value);
            }
            return $instance;
        }

        return $data;
    }
}
