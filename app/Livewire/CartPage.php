<?php

namespace App\Livewire;

use App\Services\CartService;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class CartPage extends Component
{
    public array $breadcrumbs = [['/cart', 'Корзина']];

    public Collection $items;

    public int $totalPrice;

    public function boot(CartService $cartService): void
    {
        $this->items = $cartService->getItems();

        $this->setTotalPrice();
    }

    #[On('cart-updated')]
    public function setTotalPrice(): void
    {
        $this->totalPrice = $this->items->sum(
            fn($item) => $item->quantity * $item->price,
        );
    }
}
