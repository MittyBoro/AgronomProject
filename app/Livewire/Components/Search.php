<?php

namespace App\Livewire\Components;

use App\Models\Article;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Component;

class Search extends Component
{
    public Collection $categories;

    public string $search = 'Architecto nam';

    public function render()
    {
        $this->search = trim($this->search);
        if (!empty($this->search)) {
            $products = $this->searchProducts();
            $articles = $this->searchArticles();
            $categories = $this->searchCategories();
        } else {
            $products = collect();
            $articles = collect();
            $categories = $this->categories;
        }

        return view('livewire.components.search', [
            'productsResult' => $products,
            'articlesResult' => $articles,
            'categoriesResult' => $categories,
        ]);
    }

    private function searchProducts(): Collection
    {
        return Product::selectPublic()
            ->whereAny(
                [
                    'slug',
                    'title',
                    'description',
                    'meta_title',
                    'meta_description',
                ],
                'like',
                '%' . $this->search . '%',
            )
            ->with('media')
            ->limit(15)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function searchArticles(): Collection
    {
        return Article::selectPublic()
            ->whereAny(
                [
                    'slug',
                    'title',
                    'description',
                    'content',
                    'meta_title',
                    'meta_description',
                ],
                'like',
                '%' . $this->search . '%',
            )
            ->with('media')
            ->limit(10)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function searchCategories(): Collection
    {
        return Category::selectPublic()
            ->whereAny(
                ['slug', 'title', 'meta_title', 'meta_description'],
                'like',
                '%' . $this->search . '%',
            )
            ->with('media')
            ->limit(10)
            ->orderBy('order_column', 'asc')
            ->get();
    }
}
