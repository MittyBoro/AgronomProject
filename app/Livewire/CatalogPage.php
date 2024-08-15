<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class CatalogPage extends Component
{
    use WithPagination, WithoutUrlPagination;
    use SEOToolsTrait;

    private ?Category $category = null;
    private int $perPage = 12;

    public array $breadcrumbs = [['/catalog', 'Каталог']];
    public string $title = 'Каталог';
    public ?int $categoryId = null;

    #[Session('sort')]
    public ?string $sort = '';

    public array $sortList = [
        '' => 'Новинки',
        'price-asc' => 'Сначала дешевые',
        'price-desc' => 'Сначала дорогие',
        'discount' => 'Скидка',
    ];

    public function mount(string $slug = null)
    {
        $this->mountPage($slug);
    }

    private function mountPage($slug): void
    {
        if ($slug) {
            $page = $this->getCategoryPage($slug);
        } else {
            $page = Page::publicSelect()->whereSlug('catalog')->firstOrFail();
        }
        $this->title = $page->title;

        $this->seo()
            ->setTitle($page->meta_title)
            ->setDescription($page->meta_description);
    }

    private function getCategoryPage($slug): Model
    {
        $category = Category::whereSlug($slug)->with('media')->firstOrFail();
        $this->breadcrumbs[] = [
            url('/catalog/' . $category->slug),
            $category->title,
        ];

        if ($category->preview) {
            $this->seo()
                ->opengraph()
                ->addImage($category->preview);
        }

        $this->category = $category;
        $this->categoryId = $category->id;

        return $category;
    }

    private function setJsonLd(array $products): void
    {
        foreach ($products as $product) {
            $this->seo()
                ->jsonLdMulti()
                ->newJsonLd()
                ->addValue('itemListElement', [
                    '@type' => 'Product',
                    'name' => $product->title,
                    'description' => $product->description,
                    'offers' => [
                        '@type' => 'Offer',
                        'priceCurrency' => 'RUB',
                        'price' => $product->price,
                        'url' => url('\/products\/' . $product->slug),
                        'availability' => 'http://schema.org/InStock', // или другой статус, если товар недоступен
                    ],
                    'image' => $product->preview,
                ]);
        }
    }

    public function setSort($v)
    {
        $this->sort = $v;
        session(['sort' => $v]);
        $this->resetPage();
    }

    #[Computed]
    public function currentSort()
    {
        return $this->sortList[$this->sort ?? ''];
    }

    public function render()
    {
        $sort = explode('-', $this->sort);
        $products = Product::selectPublic()
            ->when(
                $this->category,
                fn($q) => $q->whereHas(
                    'categories',
                    fn($q) => $q->whereId($this->category->id),
                ),
            )
            ->orderBy(
                match ($sort[0]) {
                    'price' => 'total_price',
                    'discount' => 'discount',
                    default => 'created_at',
                },
                $sort[1] ?? 'desc',
            )
            ->paginate(perPage: $this->perPage);

        $this->setJsonLd($products->items());

        return view('livewire.catalog-page', compact('products'));
    }
}
