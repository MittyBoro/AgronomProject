<?php

namespace App\Livewire\Lists;

use App\Models\Category;
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

    public function mount()
    {
        $this->className = 'categories__' . Str::random();

        $this->categories = Category::select('id', 'slug', 'title')
            ->with('media')
            ->limit(20)
            ->get();
    }

    public function render()
    {
        return view('livewire.category.list');
    }
}
