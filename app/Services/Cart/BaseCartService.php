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

    protected array $items = [];

    protected ?string $userId = null;

    protected ?string $sessionId = null;

    public function __construct(CartTypeEnum $type)
    {
        $this->userId = Auth::id();
        $this->sessionId = $this->userId !== null ? null : Session::getId();

        if ($this->sessionId) {
            $this->saveGuestSessionId();
        }

        $this->cart = Cart::withCount('items')->firstOrNew([
            'type' => $type,
            'user_id' => $this->userId,
            'session_id' => $this->sessionId,
        ]);
    }

    /**
     * Сохраняет id гостевой сессии
     * потребуется при объединении корзин после входа
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

        $hash = md5(
            serialize([
                'full' => $full,
                'callback' => $callback ? spl_object_hash($callback) : null,
                'loadRelated' => $loadRelated,
            ]),
        );

        if (!isset($this->items[$hash])) {
            $this->items[$hash] = $this->cart
                ->items()
                ->when($callback, $callback)
                ->when(
                    $loadRelated,
                    fn($q) => $q->when(
                        $full,
                        fn($q) => $q->with('product.media', 'variation.group'),
                        fn($q) => $q->with('product', 'variation'),
                    ),
                )
                ->get();
        }

        return $this->items[$hash];
    }

    protected function firstItemsCollection(): Collection
    {
        return $this->items[array_key_first($this->items)] ??
            $this->items(full: false);
    }

    public function count(): int
    {
        return $this->cart->items_count ?? 0;
    }

    public function totalPrice(): ?int
    {
        $items = $this->firstItemsCollection();

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
}
