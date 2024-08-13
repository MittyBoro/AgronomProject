<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductPage extends Component
{
    public Product $product;

    public array $breadcrumbs = [['/catalog', 'Каталог']];

    public function mount(Product $product)
    {
        //
    }


}
