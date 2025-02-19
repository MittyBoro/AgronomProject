<?php

namespace App\Listeners;

use App\Services\Cart\MergeCartService;
use Illuminate\Auth\Events\Login;

class LoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Объединение корзин при входе
     */
    public function handle(Login $event): void
    {
        MergeCartService::merge();
    }
}
