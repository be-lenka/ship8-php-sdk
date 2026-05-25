<?php
/**
 * ModelInterface
 *
 * @category Interface
 * @package  BeLenka\Ship8
 */

namespace BeLenka\Ship8\Model;

/**
 * Common surface implemented by every Ship8 SDK model. The shape mirrors the
 * convention used by OpenAPI Generator's PHP client, so generated models stay
 * drop-in compatible with the serializer.
 */
interface ModelInterface
{
    /**
     * @return array<string, string> property => OpenAPI type
     */
    public static function openAPITypes(): array;

    /**
     * @return array<string, string|null> property => OpenAPI format
     */
    public static function openAPIFormats(): array;

    /**
     * @return array<string, string> property => JSON attribute name
     */
    public static function attributeMap(): array;

    /**
     * @return array<string, string> property => setter method name
     */
    public static function setters(): array;

    /**
     * @return array<string, string> property => getter method name
     */
    public static function getters(): array;

    /**
     * @return array<string, bool> property => true if nullable
     */
    public static function openAPINullables(): array;

    /**
     * Original OpenAPI model name, used for debugging.
     */
    public function getModelName(): string;

    /**
     * Returns true when the model passes its required-field validation.
     *
     * @return string[] Array of validation messages (empty when valid).
     */
    public function listInvalidProperties(): array;

    public function valid(): bool;
}
