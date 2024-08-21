<?php

namespace App\Livewire\Components;

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
