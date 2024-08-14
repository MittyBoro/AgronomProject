<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViteServiceProvider extends ServiceProvider
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
        Vite::useScriptTagAttributes([
            'defer' => true, // Specify an attribute without a value...
        ]);

        Vite::macro('front', function (string $asset) {
            /** @var Vite $this */
            return $this->asset(config('app.resources.front') . "/{$asset}");
        });
    }
}
