<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Livewire\Component;

class HomePage extends Component
{
    use SEOToolsTrait;

    public ?Page $page;
    public ?string $homeTitle;
    public ?string $homeDescription;

    public ?Collection $popularProducts;
    public ?Collection $discountsProducts;
    public ?Collection $articles;
    public ?Collection $reviews;

    public function mount()
    {
        $this->getPage();
        $this->getPopularProducts();
        $this->getDiscountsProducts();
        $this->getArticles();
        $this->getReviews();
    }

    private function getPage(): void
    {
        $this->page = Page::publicSelect()->whereSlug('/')->firstOrFail();

        $homeData = $this->page->attrs['key_value'][0];
        $this->homeTitle = $homeData['home_title'] ?? null;
        $this->homeDescription = $homeData['home_description'] ?? null;

        $this->seo()->setTitle($this->page->meta_title);
        $this->seo()->setDescription($this->page->meta_description);
    }

    // популярные товары
    private function getPopularProducts(): void
    {
        $this->popularProducts = Product::selectPublic()
            ->latest()
            ->limit(4)
            ->get();
    }

    // продукты со скидкой
    private function getDiscountsProducts(): void
    {
        $this->discountsProducts = Product::selectPublic()
            ->orderBy('discount', 'desc')
            ->limit(4)
            ->get();
    }

    // последние статьи
    private function getArticles(): void
    {
        $this->articles = Article::selectPublic()->latest()->limit(3)->get();
    }

    // лучшие отзывы
    private function getReviews(): void
    {
        $this->reviews = Review::selectPublic()
            ->with('product')
            ->isPinned()
            ->limit(4)
            ->get();
    }
}
