<?php

namespace App\Livewire;

use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
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
        $this->setUserWatched();
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

    private function setUserWatched(): void
    {
        $watchedArray = Cookie::get('user_watched')
            ? json_decode(Cookie::get('user_watched'))
            : [];

        if (!in_array($this->product->id, $watchedArray)) {
            $watchedArray[] = $this->product->id;
            $watchedArray = array_slice($watchedArray, -5);
            Cookie::queue(
                'user_watched',
                json_encode($watchedArray),
                60 * 24 * 30,
            );
        }
    }
}
