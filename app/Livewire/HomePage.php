<?php

namespace App\Livewire;

use App\Models\Article;
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

    public function mount(): void
    {
        $this->setPage();
        $this->setPopularProducts();
        $this->setDiscountsProducts();
        $this->setArticles();
        $this->setReviews();
    }

    private function setPage(): void
    {
        $this->page = Page::publicSelect()->whereSlug('/')->firstOrFail();

        $homeData = $this->page->attrs['key_value'][0];
        $this->homeTitle = $homeData['home_title'] ?? null;
        $this->homeDescription = $homeData['home_description'] ?? null;

        $this->seo()->setTitle($this->page->meta_title);
        $this->seo()->setDescription($this->page->meta_description);
    }

    // популярные товары
    private function setPopularProducts(): void
    {
        $this->popularProducts = Product::selectPublic()
            ->latest()
            ->limit(4)
            ->get();
    }

    // продукты со скидкой
    private function setDiscountsProducts(): void
    {
        $this->discountsProducts = Product::selectPublic()
            ->orderBy('discount', 'desc')
            ->limit(4)
            ->get();
    }

    // последние статьи
    private function setArticles(): void
    {
        $this->articles = Article::selectPublic()->latest()->limit(3)->get();
    }

    // лучшие отзывы
    private function setReviews(): void
    {
        $this->reviews = Review::selectPublic()
            ->with('product')
            ->isPinned()
            ->limit(4)
            ->get();
    }
}
