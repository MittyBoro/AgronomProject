<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class CatalogPage extends Component
{
    use WithPagination, WithoutUrlPagination;
    use SEOToolsTrait;

    public ?Category $category;

    public array $breadcrumbs = [['/catalog', 'Каталог']];
    public string $title = 'Каталог';

    private string $sort;
    private int $perPage = 12;

    public array $sortList = [
        '' => 'Новинки',
        'price-asc' => 'Сначала дешевые',
        'price-desc' => 'Сначала дорогие',
        'discount' => 'Скидка',
    ];

    // public string $sort = '';
    public function boot()
    {
        $this->sort = session('sort', '');
    }

    public function mount(?Category $category)
    {
        $this->getPage($category);
    }

    public function setSort($v)
    {
        $this->sort = $v;
        session(['sort' => $v]);
    }

    #[Computed]
    public function currentSort()
    {
        return $this->sortList[$this->sort ?? ''];
    }

    private function getPage($category): void
    {
        if ($category->id) {
            $page = $category;
            $this->category = $category;
            $this->title = $category->title;
            $this->breadcrumbs[] = [$category->slug, $category->title];
        } else {
            $page = Page::publicSelect()->whereSlug('catalog')->firstOrFail();
        }

        $this->seo()->setTitle($page->meta_title);
        $this->seo()->setDescription($page->meta_description);
    }

    public function render()
    {
        $sort = explode('-', $this->sort);
        $products = Product::selectPublic()
            ->orderBy(
                match ($sort[0]) {
                    'price' => 'total_price',
                    'discount' => 'discount',
                    default => 'created_at',
                },
                $sort[1] ?? 'desc',
            )
            ->paginate(perPage: $this->perPage);

        return view('livewire.catalog-page', [
            'products' => $products,
        ]);
    }
}
