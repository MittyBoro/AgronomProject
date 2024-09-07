<?php

namespace App\Enums;

enum PropTypeEnum: string
{
    use LabelsTrait;

    case String = 'string';
    case Number = 'number';
    case Text = 'text';
    case Media = 'media';

    public function label(): string
    {
        return match ($this) {
            self::String => 'Строка',
            self::Number => 'Число',
            self::Text => 'Текст',
            self::Media => 'Файл',
        };
    }
}
