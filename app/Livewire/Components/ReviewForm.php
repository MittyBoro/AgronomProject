<?php

namespace App\Livewire\Components;

use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReviewForm extends Component
{
    #[Locked]
    public $productId;

    #[Validate('required|min:2|max:255')]
    public $name;

    #[Validate('required|integer|between:1,5')]
    public $rating;

    #[Validate('required|min:10|max:10000')]
    public $comment;

    private User $user;

    public function boot(): void
    {
        $this->user = Auth::user();
    }

    public function mount(): void
    {
        $this->name = $this->user->name;
    }

    public function store(): void
    {
        $this->validate();

        $data = [
            'product_id' => $this->productId,
            'user_id' => $this->user->id,
            'rating' => $this->rating,
            'name' => $this->name,
            'comment' => $this->comment,
        ];

        Review::create($data);

        session()->flash(
            'status',
            'Ваше отзыв принят! Он будет опубликован после проверки модератором.',
        );
    }

    public function validationAttributes()
    {
        return [
            'rating' => 'оценка',
        ];
    }
}
