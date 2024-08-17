<?php

use App\Http\Controllers\CartController;
use App\Livewire\ArticleListPage;
use App\Livewire\ArticlePage;
use App\Livewire\CartPage;
use App\Livewire\CatalogPage;
use App\Livewire\HomePage;
use App\Livewire\ProductPage;
use App\Livewire\SimplePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/catalog', CatalogPage::class)->name('catalog');
Route::get('/catalog/{slug}', CatalogPage::class)->name('category');
Route::get('/products/{slug}', ProductPage::class)->name('product');
Route::get('/articles', ArticleListPage::class)->name('articles');
Route::get('/articles/{article:slug}', ArticlePage::class)->name('article');

Route::group(['prefix' => 'cart', 'as' => 'cart.'], function (): void {
    Route::get('/', CartPage::class)->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
    Route::patch('/update', [CartController::class, 'update'])->name('update');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::get('/{page:slug}', SimplePage::class)->name('page');
