<?php

namespace App\Livewire\Lists;

use App\Models\Review;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ReviewList extends Component
{
    use WithoutUrlPagination, WithPagination;

    public ?string $title;

    public ?string $pretitle;

    #[Locked]
    public ?int $productId;

    #[Locked]
    public bool $canCreateReview = false;

    private int $perPage = 6;

    private int $limitOfList = 4;

    public function mount($productId = null): void
    {
        $this->productId = $productId;
    }

    public function render()
    {
        $reviews = Review::selectPublic()
            ->orderBy('order_column', 'asc')
            ->orderBy('created_at', 'desc')
            ->when(
                $this->productId,
                fn($q) => $q
                    ->where('product_id', $this->productId)
                    ->paginate($this->perPage),
                fn($q) => $q
                    ->with('product')
                    ->limit($this->limitOfList)
                    ->get(),
            );

        return view('livewire.lists.review-list', [
            'reviews' => $reviews,
        ]);
    }
}
