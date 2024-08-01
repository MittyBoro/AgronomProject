<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        return Cart::firstOrCreate([
            'user_id' => $userId,
            'session_id' => $userId ? null : $sessionId,
        ]);
    }

    public function addToCart(
        Product $product,
        array $variationIds,
        int $quantity = 1,
    ) {
        $cart = $this->getCart();

        $price = $this->calculatePrice($product, $variationIds);

        $cartItem = $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $price,
        ]);

        $cartItem->variations()->attach($variationIds);

        return $cartItem;
    }

    private function calculatePrice(Product $product, array $variationIds)
    {
        $price = $product->price;

        $variations = ProductVariation::whereIn('id', $variationIds)->get();
        foreach ($variations as $variation) {
            $price += $variation->price_modifier;
        }

        return $price;
    }

    public function removeFromCart(CartItem $cartItem): void
    {
        $cartItem->variations()->detach();
        $cartItem->delete();
    }

    public function updateQuantity(CartItem $cartItem, int $quantity): void
    {
        $cartItem->update(['quantity' => $quantity]);
    }

    public function clearCart(): void
    {
        $cart = $this->getCart();
        $cart->items->each(function ($item): void {
            $item->variations()->detach();
            $item->delete();
        });
    }

    public function getCartTotal()
    {
        $cart = $this->getCart();

        return $cart->items->sum(fn ($item) => $item->quantity * $item->price);
    }
}
