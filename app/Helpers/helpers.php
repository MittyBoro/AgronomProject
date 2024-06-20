<?php

use Illuminate\Support\Facades\Vite;

/*
 * vite_asset
 */
if (!function_exists('vite_asset')) {
    function vite_asset($path)
    {
        $resPath = 'resources/assets';
        $totalPath = $resPath . '/' . trim($path, '/');

        return Vite::asset($totalPath);
    }
}
