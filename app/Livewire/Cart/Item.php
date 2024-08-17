<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use Livewire\Component;

class Item extends Component
{
    public CartItem $item;

    public int $quantity;

    public function mount(): void
    {
        $this->quantity = $this->item->quantity;
    }

    public function updatedQuantity(int $value): void
    {
        if ($value < 1) {
            $this->quantity = 1;
        }
        if ($this->item->variation) {
            $stock = $this->item->product->stock;
        } else {
            $stock = $this->item->product->stock;
        }
        if ($value > $stock) {
            $this->quantity = $stock;
        }

        $this->item->update(['quantity' => $this->quantity]);

        $this->dispatch('cart-updated');
    }
}
