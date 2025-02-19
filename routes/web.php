<?php

use App\Http\Controllers\Payments\WebhookController;
use App\Livewire\AboutPage;
use App\Livewire\ArticleListPage;
use App\Livewire\ArticlePage;
use App\Livewire\CartPage;
use App\Livewire\CatalogPage;
use App\Livewire\CheckoutPage;
use App\Livewire\ContactPage;
use App\Livewire\HomePage;
use App\Livewire\LoyaltyPage;
use App\Livewire\ProductPage;
use App\Livewire\Profile\EditPage;
use App\Livewire\Profile\IndexPage;
use App\Livewire\Profile\LoyaltyPage as ProfileLoyaltyPage;
use App\Livewire\Profile\OrdersPage;
use App\Livewire\Profile\SingleOrderPage;
use App\Livewire\SimplePage;
use App\Livewire\WishlistPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/contacts', ContactPage::class)->name('contacts');
Route::get('/loyalty', LoyaltyPage::class)->name('loyalty');

Route::get('/catalog', CatalogPage::class)->name('catalog');
Route::get('/catalog/{slug}', CatalogPage::class)->name('category');
Route::get('/products/{slug}', ProductPage::class)->name('product');

Route::get('/articles', ArticleListPage::class)->name('articles');
Route::get('/articles/{article:slug}', ArticlePage::class)->name('article');

Route::get('/cart', CartPage::class)->name('cart');
Route::get('/wishlist', WishlistPage::class)->name('wishlist');
Route::middleware(['auth', 'verified'])
    ->get('/checkout', CheckoutPage::class)
    ->name('checkout');

Route::prefix('/profile')
    ->name('profile.')
    ->middleware(['auth'])
    ->group(function (): void {
        Route::get('/edit', EditPage::class)->name('edit');
        Route::middleware(['verified'])->group(function (): void {
            Route::get('/', IndexPage::class)->name('index');
            Route::get('/loyalty', ProfileLoyaltyPage::class)->name('loyalty');
            Route::get('/orders', OrdersPage::class)->name('orders.index');
            Route::get('/orders/{order:id}', SingleOrderPage::class)->name(
                'orders.show',
            );
        });
    });

Route::any('/payment/webhook/{method}', [
    WebhookController::class,
    'handle',
])->name('payment.webhook');

Route::get('/{page:slug}', SimplePage::class)->name('page');
