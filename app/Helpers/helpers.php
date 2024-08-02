<?php

if ( ! function_exists('faker_media_url')) {
    function faker_media_url(int $width = 700, ?int $height = null): string
    {
        if ( ! $height) {
            $height = $width;
        }

        return "https://placedog.net/{$width}/{$height}?r";
        // return "https://doodleipsum.com/{$width}";
    }
}

if ( ! function_exists('price_formatter')) {
    function price_formatter(float|int $price): string
    {
        return number_format($price, 0, ',', ' ');
    }
}

if ( ! function_exists('parse_price')) {
    function parse_price($str): float
    {
        return (float) preg_replace(
            '/[^0-9,.-]/',
            '',
            str_replace(',', '.', $str),
        );
    }
}
