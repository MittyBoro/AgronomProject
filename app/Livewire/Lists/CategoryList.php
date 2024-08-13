<?php

namespace App\Livewire\Lists;

use App\Models\Category;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryList extends Component
{
    public ?Collection $categories;

    public ?string $pretitle;
    public ?string $title;
    public ?string $className;
    public bool $swiper = false;

    public ?int $activeIndex;

    public function mount()
    {
        $this->className = 'categories__' . Str::random();

        $this->categories = Category::select('id', 'slug', 'title')
            ->with('media')
            ->limit(50)
            ->orderBy('order_column', 'asc')
            ->get();

        $activeCategory = request()->category?->id;

        if ($activeCategory) {
            $this->activeIndex = $this->categories->search(function (
                $category,
            ) use ($activeCategory) {
                return $category->id === $activeCategory;
            });
        }
    }
}
