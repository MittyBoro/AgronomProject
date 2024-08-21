<?php

namespace App\Livewire;

use App\Services\Cart\WishListService;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class WishlistPage extends Component
{
    use SEOToolsTrait;
    use WithPagination;
    private int $perPage = 24;

    public array $breadcrumbs = [
        ['/id', 'Личный кабинет'],
        ['/wishlist', 'Избранное'],
    ];

    private WishListService $wishlistService;

    public function boot(WishListService $wishlistService): void
    {
        $this->wishlistService = $wishlistService;
    }
    public function mount()
    {
        $this->seo()->setTitle('Избранное');
        $this->seo()->metatags()->addMeta('robots', 'noindex, nofollow');
    }

    public function render()
    {
        $products = $this->wishlistService
            ->getCart()
            ->items()
            ->with([
                'product' => fn($q) => $q->selectPublic(),
            ])
            ->paginate(perPage: $this->perPage)
            ->through(fn($item) => $item->product);

        return view('livewire.wishlist-page', [
            'products' => $products,
        ]);
    }
}
