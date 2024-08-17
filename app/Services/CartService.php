<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    private ?string $userId = null;

    private ?string $sessionId = null;

    private ?Cart $cart;

    private Collection $items;

    public function __construct()
    {
        $this->userId = Auth::id();
        $this->sessionId = Session::getId();

        $this->cart = Cart::firstOrNew([
            'user_id' => $this->userId,
            'session_id' => $this->userId !== null ? null : $this->sessionId,
        ]);
    }

    public function hasCart(): bool
    {
        return (bool) $this->cart->id;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getItems(): Collection
    {
        return $this->cart
            ->items()
            ->with(['product', 'variations' => fn($q) => $q->with('group')])
            ->get();
    }

    public function getProductItems(int $productId): Collection
    {
        if (!$this->cart->id) {
            return collect();
        }

        return $this->cart
            ->items()
            ->with('variations')
            ->where('product_id', $productId)
            ->get();
    }

    public function addToCart(
        $productId,
        array $variationIds,
        int $quantity = 1,
    ) {
        $this->cart->updated_at = now();
        $this->cart->save();

        $cartItem = $this->cart->items()->create([
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        $cartItem->variations()->attach($variationIds);

        return $cartItem;
    }

    public function firstInCart(
        int $productId,
        ?int $variationId = null,
    ): ?CartItem {
        $cart = $this->getCart();
        $cartItem = $cart
            ->items()
            ->where('product_id', $productId)
            ->when(
                $variationId,
                fn($q) => $q->whereHas(
                    'variations',
                    fn($query) => $query->where('id', $variationId),
                ),
            )
            ->first();

        return $cartItem;
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
        $items = $this->getItems();

        return $items->sum(fn($item) => $item->quantity * $item->price);
    }
}
