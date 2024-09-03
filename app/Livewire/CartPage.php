<?php

namespace App\Livewire;

use App\Services\Cart\CartService;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class CartPage extends Component
{
    use SEOToolsTrait;

    public array $breadcrumbs = [['/cart', 'Корзина']];

    public Collection $items;

    public int $totalPrice;

    private CartService $cartService;

    public function boot(CartService $cartService): void
    {
        $this->cartService = $cartService;
    }

    public function mount(): void
    {
        $this->items = $this->cartService->items(full: true);
        if ($this->cartService->checkStock()) {
            $this->addError(
                'stock',
                'Состав корзины изменен, ознакомьтесь с обновлёнными данными',
            );
        }
        $this->setTotalPrice();

        $this->seo()->setTitle('Корзина');
        $this->seo()->metatags()->addMeta('robots', 'noindex, nofollow');
    }

    #[On('cart-updated')]
    public function setTotalPrice(): void
    {
        $this->totalPrice = $this->cartService->totalPrice($this->items);
    }
}
