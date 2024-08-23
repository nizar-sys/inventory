<?php

namespace App\Helpers;

use BenSampo\Enum\Enum;

class EnumHelper
{
    /**
     * Get the description of an enum value.
     *
     * @param Enum $enum
     * @param int|string $value
     * @return string
     */
    public static function getDescription(string $enumClass, $value): string
    {
        return $enumClass::getDescription($value);
    }

    /**
     * Get the key of an enum value.
     *
     * @param string $enumClass
     * @param int|string $value
     * @return string
     */
    public static function getKey(string $enumClass, $value): string
    {
        return $enumClass::getKey($value);
    }

    /**
     * Get the enum instance by key.
     *
     * @param Enum $enum
     * @param string $key
     * @return Enum
     */
    public static function getEnumByKey(string $enumClass, $keys)
    {
        if (is_array($keys)) {
            return array_map(function ($key) use ($enumClass) {
                return $enumClass::fromKey($key);
            }, $keys);
        }

        return $enumClass::fromKey($keys);
    }

    /**
     * Get the enum instance by value.
     *
     * @param Enum $enum
     * @param int|string $value
     * @return Enum
     */
    public static function getEnumByValue(Enum $enum, $value): Enum
    {
        return $enum::fromValue($value);
    }

    /**
     * Get all keys and values as an associative array.
     *
     * @param Enum $enum
     * @return array
     */
    public static function getAll(Enum $enum): array
    {
        return $enum::asArray();
    }
}
