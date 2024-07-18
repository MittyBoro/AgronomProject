<?php

namespace App\Enums;

enum VariationGroupTypeEnum: string
{
    use LabelsTrait;

    case String = 'string';
    case Number = 'number';
    case Color = 'color';

    public function label(): string
    {
        return match ($this) {
            self::String => 'Строка',
            self::Number => 'Число',
            self::Color => 'Цвет',
        };
    }
}
