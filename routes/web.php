<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('{path}', function ($path = null) {
    return view($path);
});
