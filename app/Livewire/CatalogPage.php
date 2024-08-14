<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Session;
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

    #[Session('sort')]
    public ?string $sort = '';
    private int $perPage = 12;

    public array $sortList = [
        '' => 'Новинки',
        'price-asc' => 'Сначала дешевые',
        'price-desc' => 'Сначала дорогие',
        'discount' => 'Скидка',
    ];

    public function mount(?Category $category)
    {
        $this->setPage($category);
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

    private function setPage($category): void
    {
        if ($category->id) {
            $page = $category;
            $this->category = $category;
            $this->title = $category->title;
            $this->breadcrumbs[] = [url('/catalog/' . $category->slug), $category->title];

            if ($category->preview) {
                $this->seo()
                    ->opengraph()
                    ->addImage($category->preview);
            }
        } else {
            $page = Page::publicSelect()->whereSlug('catalog')->firstOrFail();
        }

        $this->seo()
            ->setTitle($page->meta_title)
            ->setDescription($page->meta_description);
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

        $this->setJsonLd($products->items());

        return view('livewire.catalog-page', [
            'products' => $products,
        ]);
    }
}
