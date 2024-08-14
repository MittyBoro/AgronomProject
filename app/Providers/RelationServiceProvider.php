<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class RelationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'article' => 'App\Models\Article',
            'banner' => 'App\Models\Banner',
            'cart' => 'App\Models\Cart',
            'cart_item' => 'App\Models\CartItem',
            'category' => 'App\Models\Category',
            'page' => 'App\Models\Page',
            'product' => 'App\Models\Product',
            'product_variation' => 'App\Models\ProductVariation',
            'review' => 'App\Models\Review',
            'user' => 'App\Models\User',
            'variation_group' => 'App\Models\VariationGroup',
        ]);
    }
}
