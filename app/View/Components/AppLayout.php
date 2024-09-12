<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class AppLayout extends Component
{
    public Collection $categories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categories = Category::select('id', 'slug', 'title')
            ->with('media')
            ->limit(50)
            ->orderBy('order_column', 'asc')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.app');
    }
}
