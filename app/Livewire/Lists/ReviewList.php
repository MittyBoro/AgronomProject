<?php

namespace App\Livewire\Lists;

use Illuminate\Support\Collection;
use Livewire\Component;

class ReviewList extends Component
{
    public ?Collection $reviews;

    public ?string $pretitle;
    public ?string $title;
    public ?array $button;

    public function mount(Collection $reviews)
    {
        $this->reviews = $reviews;
    }

    public function render()
    {
        return view('livewire.review.list');
    }
}
