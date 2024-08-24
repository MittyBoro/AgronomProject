<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;

class MergeCartService
{
    /**
     * Объединяет корзину гостя с корзиной авторизованного пользователя
     */
    public static function merge(): void
    {
        $guestSessionId = Session::get('guest_session_id');
        if (!$guestSessionId) {
            return;
        }

        Cart::where('session_id', $guestSessionId)
            ->with('items:cart_id,product_id,product_variation_id,quantity')
            ->get()
            ->each(function (Cart $cart): void {
                if ($cart->items->count()) {
                    $cartService = new BaseCartService($cart->type);

                    $cart->items->each(function (CartItem $item) use (
                        $cartService,
                    ): void {
                        $cartService->add(
                            $item->product_id,
                            $item->product_variation_id,
                            $item->quantity,
                        );
                    });
                }

                $cart->delete();
            });
    }
}
