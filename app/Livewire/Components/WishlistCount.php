<?php

namespace App\Livewire\Components;

use App\Enums\CartListType;
use App\Enums\CartTypeEnum;
use App\Services\Cart\CartService;
use App\Services\Cart\WishListService;
use Livewire\Attributes\On;
use Livewire\Component;

class WishlistCount extends Component
{
    public ?int $count;
    public string $class = '';

    #[On('wishlist-updated')]
    public function mount(WishListService $service): void
    {
        $this->count = $service->count();
    }

    public function render()
    {
        return view('livewire.components.cart-count');
    }
}
