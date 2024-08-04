<?php

namespace App\View\Components\Layouts;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Main extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Page|Category|Product $page,
        public Collection $categories,
    ) {
        $this->categories = Category::select('id', 'slug', 'title')
            ->with('media')
            ->limit(20)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.main', [
            'categories' => $this->categories,
        ]);
    }
}
