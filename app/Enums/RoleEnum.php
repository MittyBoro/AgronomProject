<?php

namespace App\Enums;

enum RoleEnum: string
{
    use LabelsTrait;

    case Admin = 'admin';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Администратор',
            self::User => 'Пользователь',
        };
    }
}
