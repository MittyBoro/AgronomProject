<?php

namespace App\Services\Cart;

use App\Enums\CartTypeEnum;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Closure;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BaseCartService
{
    protected Cart $cart;

    protected Collection $items;

    protected ?string $userId = null;

    protected ?string $sessionId = null;

    public function __construct(CartTypeEnum $type)
    {
        $this->userId = Auth::id();
        $this->sessionId = $this->userId !== null ? null : Session::getId();

        if ($this->sessionId) {
            $this->saveGuestSessionId();
        }

        $this->cart = Cart::firstOrNew([
            'type' => $type,
            'user_id' => $this->userId,
            'session_id' => $this->sessionId,
        ]);
    }

    /**
     * Сохраняет id гостевой сессии
     * потребуется при объединении корзин после входа
     *
     * @return void
     */
    public function saveGuestSessionId(): void
    {
        if (Session::get('guest_session_id') === null) {
            Session::put('guest_session_id', $this->sessionId);
        }
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function add(
        int $productId,
        ?int $variationId = null,
        int $quantity = 1,
    ): CartItem {
        $this->cart->touch(); // что бы понимать, что клиент пользуется корзиной

        // проверка наличия продукта и вариации
        $product = $this->findProduct($productId, $variationId);
        if (!$product) {
            throw new Exception('Товар не найден');
        }

        $stock = $product->variation?->stock ?? $product->stock;

        $quantity = min($quantity, $stock);

        $item = $this->cart->items()->updateOrCreate(
            [
                'product_id' => $productId,
                'product_variation_id' => $variationId,
            ],
            [
                'quantity' => $quantity,
            ],
        );

        return $item;
    }

    public function delete(
        ?int $productId,
        ?int $variationId = null,
        ?int $itemId = null,
    ): void {
        if ($itemId) {
            $this->cart->items()->where('id', $itemId)->delete();
        } else {
            $this->cart
                ->items()
                ->where([
                    'product_id' => $productId,
                    'product_variation_id' => $variationId,
                ])
                ->delete();
        }
    }

    public function items(
        bool $full = true,
        ?Closure $callback = null,
        bool $loadRelated = true,
    ): Collection {
        if (!$this->cart->id) {
            return collect();
        }

        return $this->cart
            ->items()
            ->when($callback, $callback)
            ->when(
                $loadRelated,
                fn($q) => $q->when(
                    $full,
                    fn($q) => $q->with('product.media', 'variation'),
                    fn($q) => $q->with('product', 'variation'),
                ),
            )
            ->get();
    }

    public function count(): int
    {
        return $this->cart->items()->count();
    }

    public function totalPrice(?Collection $items = null): ?int
    {
        $items ??= $this->items(full: false);

        return $items->sum(
            fn($item): float => $item->quantity * $item->total_price,
        ) ?? 0;
    }

    public function findProduct(
        int $productId,
        ?int $variationId = null,
    ): ?Product {
        $product = Product::when(
            $variationId,
            fn($query) => $query->whereHas(
                'variations',
                fn($query) => $query->where('id', $variationId),
            ),
        )->find($productId);

        return $product;
    }

    // add
    // remove
    // update
    // clear
    // getTotal
    // validate

    /**
     * Обновить время обновления корзины
     * (что бы понимать, что клиент пользуется корзиной)
     */
    // protected function updateCartTimestamp(): void
    // {
    //     if (
    //         !$this->cart->id ||
    //         $this->cart->updated_at > now()->subMinutes(5)
    //     ) {
    //         $this->cart->touch();
    //     }
    // }

    // public function getCart(): Cart
    // {
    //     return $this->cart;
    // }

    // public function getCount(?CartTypeEnum $list = null): ?int
    // {
    //     return $this->cart
    //         ->items()
    //         ->when($list, fn($q) => $q->where('list', $list))
    //         ->count();
    // }
    // public function validateItems(): void
    // {
    //     $this->cart
    //         ->items()
    //         ->with([
    //             'product' => fn($q) => $q->withCount('variations'),
    //             'variations',
    //         ])
    //         ->get()
    //         ->each(function (CartItem $item) {
    //             if ($item->product->variations_count) {
    //                 // если у продукта есть вариации, а у элемента в корзине нет - удалить
    //                 if ($item->variations->isEmpty()) {
    //                     return $item->delete();
    //                 }
    //                 // уточнить максимальное количество для элемента в корзине
    //                 $maxQuantity = $item->variations->min('stock');
    //             } else {
    //                 // если у продукта нет вариации, а у элемента в корзине есть - удалить
    //                 if ($item->variations->isNotEmpty()) {
    //                     return $item->delete();
    //                 }
    //                 // уточнить максимальное количество для элемента в корзине
    //                 $maxQuantity = $item->product->stock;
    //             }

    //             $item->quantity = min($item->quantity, $maxQuantity);
    //             $item->save();
    //         });
    // }

    // public function getProductItems(int $productId): Collection
    // {
    //     if (!$this->cart->id) {
    //         return collect();
    //     }

    //     return $this->cart
    //         ->items()
    //         ->with('variations')
    //         ->where('product_id', $productId)
    //         ->get();
    // }

    // public function addToCart(
    //     $productId,
    //     array $variationIds,
    //     int $quantity = 1,
    // ) {
    //     if ($quantity < 1) {
    //         return false;
    //     }

    //     $variationIds = array_filter($variationIds);

    //     if ($this->cart->id) {
    //         $existInCart = $this->findInCart($productId, $variationIds);
    //         if ($existInCart) {
    //             $this->updateQuantity($existInCart, $quantity);
    //             return $existInCart;
    //         }
    //     }

    //     $productExists = Product::when(
    //         !empty($variationIds),
    //         fn($q) => $q->whereHas(
    //             'variations',
    //             fn($q) => $q
    //                 ->whereIn('id', $variationIds)
    //                 ->where('stock', '>=', $quantity),
    //         ),
    //         fn($q) => $q->where('stock', '>=', $quantity),
    //     )
    //         ->whereId($productId)
    //         ->exists();

    //     if (!$productExists) {
    //         return false;
    //     }

    //     $this->updateCartTimestamp();

    //     $cartItem = $this->cart->items()->create([
    //         'product_id' => $productId,
    //         'quantity' => $quantity,
    //     ]);

    //     $cartItem->variations()->attach($variationIds);

    //     return $cartItem;
    // }

    // public function findInCart(
    //     int $productId,
    //     ?array $variationIds = [],
    //     $list = 'cart',
    // ): ?CartItem {
    //     $variationIds = array_filter($variationIds);

    //     $cartItem = $this->cart
    //         ->items()
    //         ->where('product_id', $productId)
    //         ->where('list', $list)
    //         ->when(
    //             !empty($variationIds),
    //             fn($q) => $q->whereHas(
    //                 'variations',
    //                 fn($query) => $query->whereIn('id', $variationIds),
    //             ),
    //         )
    //         ->first();

    //     return $cartItem;
    // }

    // public function removeFromCart(CartItem $cartItem): void
    // {
    //     $cartItem->delete();
    // }

    // public function updateQuantity(CartItem $cartItem, int $quantity): void
    // {
    //     $this->updateCartTimestamp();

    //     $cartItem->update(['quantity' => $quantity]);
    // }

    // public function clearCart($list = 'cart'): void
    // {
    //     $this->updateCartTimestamp();

    //     $this->cart
    //         ->items()
    //         ->where('list', $list)
    //         ->cursor(function ($item): void {
    //             $item->delete();
    //         });
    // }

    // public function getCartTotal()
    // {
    //     $items = $this->getItems();

    //     return $items->sum(fn($item) => $item->quantity * $item->price);
    // }
}
