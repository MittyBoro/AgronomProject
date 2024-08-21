<?php

namespace App\Livewire\Components;

use App\Models\CartItem as CartItemModel;
use Livewire\Component;

class CartItem extends Component
{
    public CartItemModel $item;

    public int $quantity;

    public function mount(): void
    {
        $this->quantity = $this->item->quantity;
    }

    public function updatedQuantity(int $value): void
    {
        if ($this->item->variation) {
            $stock = $this->item->variation->stock;
        } else {
            $stock = $this->item->product->stock;
        }
        $this->quantity = min($value, $stock);

        if ($value < 1) {
            $this->item->delete();
        } else {
            $this->item->update(['quantity' => $this->quantity]);
        }

        $this->dispatch('cart-updated');
    }
}
