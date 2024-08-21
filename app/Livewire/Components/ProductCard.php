<?php

namespace App\Livewire\Components;

use App\Models\Product;
use App\Services\Cart\WishListService;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class ProductCard extends Component
{
    public Product $product;

    private WishListService $wishlistService;

    public $inWishlist = false;

    public function boot(WishListService $wishlistService): void
    {
        $this->wishlistService = $wishlistService;

        $this->inWishlist = $this->wishlistService->inList(
            $this->product['id'],
        );
    }

    // добавить в вишлист
    #[Renderless]
    public function toggleWishlist(): void
    {
        $this->inWishlist = $this->wishlistService->toggle(
            $this->product['id'],
        );
        $this->dispatch('wishlist-updated');
    }
}
