<?php

namespace App\Livewire;

use App\Enums\OrderStatusEnum;
use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ProductPage extends Component
{
    use SEOToolsTrait;

    public Product $product;

    #[Locked]
    public int $productId;

    #[Locked]
    public int $canCreateReview = 0;

    public ?Collection $similar;

    public array $breadcrumbs = [['/catalog', 'Каталог']];

    public function mount($slug): void
    {
        $this->product = Product::whereSlug($slug)
            ->selectPublic(full: true)
            ->firstOrFail();

        $this->productId = $this->product->id;

        $this->product->append('grouped_variations');

        $this->setBreadcrumbs();
        $this->setSeo();
        $this->setSimilar();
        $this->setUserWatched();
        $this->setCanCreateReview();
    }

    public function setSeo(): void
    {
        $this->seo()
            ->setTitle($this->product->meta_title)
            ->setDescription($this->product->meta_description);
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

    private function setCanCreateReview(): void
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        if ($user) {
            $this->canCreateReview = $user
                ->orders()
                ->where('status', OrderStatusEnum::Completed)
                ->whereHas('items', function ($query): void {
                    $query->where('product_id', $this->productId);
                })
                ->exists();
        }
    }
}
