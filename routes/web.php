<?php

use App\Livewire\AboutPage;
use App\Livewire\ArticleListPage;
use App\Livewire\ArticlePage;
use App\Livewire\CartPage;
use App\Livewire\CatalogPage;
use App\Livewire\ContactPage;
use App\Livewire\HomePage;
use App\Livewire\ProductPage;
use App\Livewire\SimplePage;
use App\Livewire\WishlistPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/contacts', ContactPage::class)->name('contacts');

Route::get('/catalog', CatalogPage::class)->name('catalog');
Route::get('/catalog/{slug}', CatalogPage::class)->name('category');
Route::get('/products/{slug}', ProductPage::class)->name('product');

Route::get('/articles', ArticleListPage::class)->name('articles');
Route::get('/articles/{article:slug}', ArticlePage::class)->name('article');

Route::get('/cart', CartPage::class)->name('cart');
Route::get('/wishlist', WishlistPage::class)->name('wishlist');

Route::get('/{page:slug}', SimplePage::class)->name('page');
