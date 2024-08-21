<?php

namespace App\Livewire\Components;

use App\Services\Cart\CartService;
use App\Services\Cart\WishListService;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductDetail extends Component
{
    public array $product;

    private CartService $cartService;

    private WishListService $wishlistService;

    public bool $inCart = false;

    public int $quantity = 1;

    public ?int $activeVariationId = null;

    public function boot(
        CartService $cartService,
        WishListService $wishlistService,
    ): void {
        $this->cartService = $cartService;
        $this->wishlistService = $wishlistService;
    }

    public function mount(): void
    {
        $this->setActiveVariation();
    }

    #[Computed]
    #[On('wishlist-updated')]
    public function inWishlist(): bool
    {
        return $this->wishlistService->inList($this->product['id']);
    }

    // добавить в вишлист
    public function toggleWishlist(): void
    {
        $this->wishlistService->toggle($this->product['id']);

        $this->dispatch('wishlist-updated');
    }

    // устанавливает активную вариацию, помечает кол-во и наличие в корзине
    // если нет вариации, то устанавливает первую
    private function setActiveVariation(): void
    {
        $variations = Arr::pluck($this->product['variations'], 'id');

        // найти вариацию без загрузки зависимостей
        $cartItem = $this->cartService
            ->items(
                full: false,
                loadRelated: false,
                callback: fn($q) => $q
                    ->where('product_id', $this->product['id'])
                    ->whereIn('product_variation_id', $variations),
            )
            ->first();

        if (!$cartItem) {
            if (!empty($variations)) {
                $this->activeVariationId =
                    $this->product['variations'][0]['id'];

                return;
            }
        } else {
            $this->quantity = $cartItem->quantity;
            $this->activeVariationId = $cartItem->product_variation_id;
            $this->inCart = true;
        }
    }

    // проверяет есть ли в корзине активная вариация
    public function updatedActiveVariationId(int $variationId): void
    {
        $cartItem = $this->cartService
            ->items(
                false,
                fn($q) => $q
                    ->where('product_id', $this->product['id'])
                    ->where('product_variation_id', $variationId),
            )
            ->first();

        if ($cartItem) {
            $this->quantity = $cartItem->quantity;
            $this->inCart = true;
        } else {
            $this->inCart = false;
            $this->quantity = 1;
        }
    }

    // добавляет товар в корзину
    public function addToCart(CartService $cartService): void
    {
        $add = $cartService->add(
            $this->product['id'],
            $this->activeVariationId,
            $this->quantity,
        );
        if (!$add) {
            $this->addError('cart', 'Не удалось добавить товар в корзину');

            return;
        }

        $this->inCart = true;
        $this->dispatch('cart-updated');
    }

    // получить текущую вариацию товара, если есть
    public function getActiveVariation(): ?array
    {
        if (!empty($this->product['variations'])) {
            return Arr::first(
                $this->product['variations'],
                fn(array $value) => $this->activeVariationId === $value['id'],
            );
        }

        return null;
    }

    // возвращает остаток товара или активной вариации
    #[Computed]
    public function stock(): ?int
    {
        $activeVariation = $this->getActiveVariation();

        return !empty($activeVariation)
            ? $activeVariation['stock']
            : $this->product['stock'];
    }

    // возвращает цену товара или активной вариации
    #[Computed]
    public function price(): ?int
    {
        $activeVariation = $this->getActiveVariation();

        return $this->product['price'] +
            ($activeVariation['price_modifier'] ?? 0);
    }

    // возвращает цену товара или активной вариации с учетом скидки
    #[Computed]
    public function totalPrice(): ?int
    {
        $discountFactor = 1 - $this->product['discount'] / 100;

        return $this->price() * $discountFactor;
    }

    // количество
    public function updatedQuantity(int $v): void
    {
        $this->quantity = match (true) {
            $v < 1 => 1,
            $v > $this->stock => $this->stock,
            $v > 100 => 100,
            default => $v,
        };

        $this->updateCartQuantity();
    }

    // обновить, если есть в корзине
    public function updateCartQuantity(): void
    {
        if (!$this->inCart) {
            return;
        }
        $this->cartService->add(
            $this->product['id'],
            $this->activeVariationId,
            $this->quantity,
        );
    }
}
