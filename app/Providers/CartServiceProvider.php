<?php

namespace App\Providers;

use App\Services\Cart\CartService;
use App\Services\Cart\WishListService;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CartService::class, fn() => new CartService());

        $this->app->singleton(
            WishListService::class,
            fn() => new WishListService(),
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
