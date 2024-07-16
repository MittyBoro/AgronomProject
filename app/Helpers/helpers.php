<?php

if (!function_exists('faker_media_url')) {
    function faker_media_url()
    {
        return 'https://placedog.net/700/700?r';
        return 'https://doodleipsum.com/700';
    }
}

if (!function_exists('price_formatter')) {
    function price_formatter(float|int $price): string
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
