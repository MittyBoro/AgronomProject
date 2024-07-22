<?php

namespace App\Enums;

trait LabelsTrait
{
    abstract public static function cases(): array;

    public static function values(): array
    {
        return array_map(fn ($enum) => $enum->value, static::cases());
    }

    public static function labels(): array
    {
        return array_map(fn ($enum) => $enum->label(), static::cases());
    }

    public static function array(): array
    {
        return array_combine(static::values(), static::labels());
    }
}
