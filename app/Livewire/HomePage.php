<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Collection;
use Livewire\Component;

class HomePage extends Component
{
    public ?Page $page;
    public ?Collection $popularProducts;
    public ?Collection $discountsProducts;
    public ?Collection $articles;
    public ?Collection $reviews;

    public function mount()
    {
        $this->page = Page::publicSelect()->whereSlug('/')->first();

        // лучшие отзывы
        $this->reviews = Review::selectPublic()
            ->with('product')
            ->isPinned()
            ->limit(4)
            ->get();

        // популярные товары
        $this->popularProducts = Product::selectPublic()
            ->latest()
            ->limit(4)
            ->get();

        // скидки
        $this->discountsProducts = Product::selectPublic()
            ->orderBy('discount', 'desc')
            ->limit(4)
            ->get();

        // последние статьи
        $this->articles = Article::selectPublic()->latest()->limit(3)->get();
    }

}
