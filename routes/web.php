<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class)->name('index');
Route::get('/catalog', CatalogController::class)->name('catalog');
Route::get('/catalog/{category:slug}', CatalogController::class)->name('catalog');

Route::get('/products/{product:slug}', ProductController::class)->name('product');

Route::group(['prefix' => 'cart', 'as' => 'cart.'], function (): void {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
    Route::patch('/update', [CartController::class, 'update'])->name('update');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::get('{path}', fn($path = null) => view($path));
