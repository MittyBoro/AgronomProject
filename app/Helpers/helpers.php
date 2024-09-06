<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

if (!function_exists('add_session_error')) {
    function add_session_error(string $error_msg, string $key = 'default'): void
    {
        $errors = Session::get('errors', new ViewErrorBag());

        if (!$errors instanceof ViewErrorBag) {
            $errors = new ViewErrorBag();
        }

        $bag = $errors->getBags()['default'] ?? new MessageBag();
        $bag->add($key, $error_msg);

        Session::flash('errors', $errors->put('default', $bag));
    }
}

if (!function_exists('faker_media_url')) {
    function faker_media_url(int $width = 700, ?int $height = null): string
    {
        if (!$height) {
            $height = $width;
        }

        return "https://placedog.net/{$width}/{$height}?r";
        // return "https://doodleipsum.com/{$width}";
    }
}

if (!function_exists('price_formatter')) {
    function price_formatter(null|float|int $price): string
    {
        return number_format($price, 0, ',', ' ');
    }
}

if (!function_exists('parse_price')) {
    function parse_price($str): float
    {
        return (float) preg_replace(
            '/[^0-9,.-]/',
            '',
            str_replace(',', '.', $str),
        );
    }
}

if (!function_exists('phone_formatter')) {
    function phone_formatter($from): string
    {
        return sprintf(
            '%s %s %s %s',
            mb_substr($from, 0, 2),
            mb_substr($from, 2, 3),
            mb_substr($from, 5, 3),
            mb_substr($from, 8),
        );
    }
}

if (!function_exists('sklonenie')) {
    function sklonenie($number, array $txt, $cases = [2, 0, 1, 1, 1, 2])
    {
        $number = (int) $number;

        return $txt[
            $number % 100 > 4 && $number % 100 < 20
                ? 2
                : $cases[min($number % 10, 5)]
        ];
    }
}

if (!function_exists('inbox_url')) {
    function inbox_url($email)
    {
        // Разделяем email на имя пользователя и домен
        [$user, $domain] = explode('@', $email);

        // Формируем ссылку на входящие в зависимости от домена
        switch (mb_strtolower($domain)) {
            case 'gmail.com':
                return 'https://mail.google.com/mail/u/0/#inbox';
            case 'yahoo.com':
                return 'https://mail.yahoo.com/';
            case 'outlook.com':
            case 'hotmail.com':
            case 'live.com':
                return 'https://outlook.live.com/mail/inbox';
            case 'mail.ru':
                return 'https://e.mail.ru/inbox/';
            case 'yandex.ru':
            case 'ya.ru':
                return 'https://mail.yandex.ru/inbox/';
            case 'protonmail.com':
                return 'https://mail.proton.me/u/0/inbox';
            case 'icloud.com':
                return 'https://www.icloud.com/mail';
            default:
                return null;
        }
    }
}

if (!function_exists('cache_filament_badge')) {
    function cache_filament_badge($name, Closure $data)
    {
        return Cache::remember(
            'filament.badge.' . $name,
            now()->addMinute(),
            $data,
        );
    }
}
