<?php

namespace App\Livewire\Components;

use App\Services\Cart\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCount extends Component
{
    public ?int $count;

    public string $class = '';

    #[On('cart-updated')]
    public function mount(CartService $service): void
    {
        $this->count = $service->count();
    }
}
