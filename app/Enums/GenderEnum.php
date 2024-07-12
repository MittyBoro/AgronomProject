<?php

namespace App\Enums;

enum GenderEnum: string
{
    use LabelsTrait;

    case Male = 'male';
    case Female = 'female';

    public function label(): string
    {
        return match ($this) {
            self::Male => 'Мужчина',
            self::Female => 'Женщина',
            default => 'Не указано',
        };
    }
}
