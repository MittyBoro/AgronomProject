<?php

namespace App\Livewire\Lists;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ReviewList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public ?string $title;
    public ?string $pretitle;
    public ?int $productId;

    private int $perPage = 6;
    private int $limitOfList = 4;

    public function mount($productId = null)
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
