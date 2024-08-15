<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Review;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductPage extends Component
{
    use SEOToolsTrait;

    public Product $product;
    public ?Collection $similar;
    public ?Collection $reviews;

    public array $breadcrumbs = [['/catalog', 'Каталог']];

    public function mount($slug)
    {
        $this->product = Product::whereSlug($slug)
            ->selectPublic(full: true)
            ->firstOrFail()
            ->append('grouped_variations');

        $this->setBreadcrumbs();
        $this->setReviews();
        $this->setSimilar();
    }

    private function setBreadcrumbs()
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

    private function setSimilar()
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

    private function setReviews()
    {
        $this->reviews = Review::selectPublic()
            ->where('product_id', $this->product->id)
            ->limit(50)
            ->get();
    }
}
