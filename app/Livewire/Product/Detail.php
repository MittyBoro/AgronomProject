<?php

namespace App\Livewire\Product;

use App\Services\CartService;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Detail extends Component
{
    public array $product;

    public string $description;

    public ?int $activeVariationId = null;

    private CartService $cartService;

    public bool $inCart = false;

    public int $quantity = 1;

    public function boot(CartService $cartService): void
    {
        $this->cartService = $cartService;
    }

    public function mount(): void
    {
        $this->setActiveVariation();
    }

    // устанавливает активную вариацию, помечает кол-во и наличие в корзине
    private function setActiveVariation(): void
    {
        $variations = Arr::pluck($this->product['variations'], 'id');
        if (empty($variations)) {
            return;
        }

        $activeVariationId = $this->product['variations'][0]['id']; // default

        $cartItem = $this->cartService
            ->getProductItems($this->product['id'])
            ->first();

        if ($cartItem) {
            $activeVariation = $cartItem->variations->first()?->id;

            if (in_array($activeVariation, $variations)) {
                $activeVariationId = $activeVariation;

                $this->inCart = true;
                $this->quantity = $cartItem->quantity;
            }
        }

        $this->activeVariationId = $activeVariationId;
    }

    // проверяет есть ли в корзине активная вариация
    public function updatedActiveVariationId($vId): void
    {
        $cartItem = $this->cartService->firstInCart($this->product['id'], $vId);

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
        $cartService->addToCart(
            $this->product['id'],
            [$this->activeVariationId],
            $this->quantity,
        );

        $this->inCart = true;
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

        $activeVariation = $this->getActiveVariation();

        return $this->product['total_price'] +
            ($activeVariation['price_modifier'] ?? 0) * $discountFactor;
    }

    // количество
    public function updatedQuantity(int $v): void
    {
        $this->quantity = $v;
        if ($this->quantity > $this->stock) {
            $this->quantity = $this->stock;
        }
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }

        $this->updateCartQuantity();
    }

    // обновить, если есть в корзине
    public function updateCartQuantity(): void
    {
        if (!$this->inCart) {
            return;
        }
        $cartItem = $this->cartService->firstInCart(
            $this->product['id'],
            $this->activeVariationId,
        );

        if ($cartItem) {
            $this->cartService->updateQuantity($cartItem, $this->quantity);
        }
    }
}
