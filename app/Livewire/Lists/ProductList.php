<?php

namespace App\Livewire\Lists;

use Illuminate\Support\Collection;
use Livewire\Component;

class ProductList extends Component
{
    public ?Collection $products;

    public ?string $pretitle;
    public ?string $title;
    public ?array $button;

    public function mount(Collection $products)
    {
        $this->products = $products;
    }

    public function render()
    {
        return view('livewire.product.list');
    }
}
