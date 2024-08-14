<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CartController;
use App\Livewire\CatalogPage;
use App\Livewire\HomePage;
use App\Livewire\ProductPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/catalog', CatalogPage::class)->name('catalog');
Route::get('/catalog/{category:slug}', CatalogPage::class)->name('category');
Route::get('/products/{slug}', ProductPage::class)->name('product');


// Route::get('/articles', [ArticleController::class, 'index'])->name(
//     'articles.index',
// );
// Route::get('/articles/{article:slug}', [
//     ArticleController::class,
//     'show',
// ])->name('articles.show');

Route::group(['prefix' => 'cart', 'as' => 'cart.'], function (): void {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
    Route::patch('/update', [CartController::class, 'update'])->name('update');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::get('{path}', fn($path = null) => view($path));
