<?php

namespace App\Livewire;

use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductPage extends Component
{
    use SEOToolsTrait;

    public Product $product;

    public ?Collection $similar;

    public array $breadcrumbs = [['/catalog', 'Каталог']];

    public function mount($slug): void
    {
        $this->product = Product::whereSlug($slug)
            ->selectPublic(full: true)
            ->firstOrFail();

        $this->product->append('grouped_variations');

        $this->setBreadcrumbs();
        $this->setSimilar();
    }

    private function setBreadcrumbs(): void
    {
        $category = $this->product->categories->first();
        if ($category) {
            $this->breadcrumbs[] = [
                url('catalog' . '/' . $category->slug),
                $category->title,
            ];
        }
        $this->breadcrumbs[] = ['', $this->product->title];
    }

    private function setSimilar(): void
    {
        $this->similar = Product::selectPublic()
            ->where('id', '!=', $this->product->id)
            ->whereHas(
                'categories',
                fn($q) => $q->whereIn(
                    'id',
                    $this->product->categories->pluck('id')->toArray(),
                ),
            )
            ->limit(4)
            ->inRandomOrder()
            ->get();
    }
}
