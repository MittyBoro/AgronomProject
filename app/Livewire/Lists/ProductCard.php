<?php

namespace App\Livewire\Lists;

use App\Models\Product;
use Livewire\Component;

class ProductCard extends Component
{
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

}
