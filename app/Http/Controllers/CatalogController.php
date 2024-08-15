<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

final class CatalogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $category = null)
    {
        if ($category) {
            $category = Category::whereSlug($category)->firstOrFail();
        }

        $sort = $request->input('sort', '');

        // популярные товары
        $products = Product::selectPublic()
            ->orderBy(
                match ($sort) {
                    'price-asc' => 'total_price',
                    'price-desc' => 'total_price',
                    'discount' => 'discount',
                    default => 'created_at',
                },
                match ($sort) {
                    'price-asc' => 'asc',
                    'price-desc' => 'desc',
                    'discount' => 'desc',
                    default => 'desc',
                },
            )
            ->when(
                $category,
                fn($q) => $q->whereHas(
                    'categories',
                    fn($q) => $q->whereId($category->id),
                ),
            )
            ->paginate(12)
            ->withQueryString();

        // обычный шаблон
        if ($request->header('Content-Type') !== 'application/json') {
            return $this->responseWithLayout($products, $category, $sort);
        }
        // если нужна только часть страницы, то json с html кодом каталога

        return $this->responseListOnly($products, $category);
    }

    // запрос для «дорисовки»
    public function responseListOnly($products, $category)
    {
        return [
            'html' => view(
                'components.products.list',
                compact('products'),
            )->render(),
        ];
    }

    // обычный запрос
    public function responseWithLayout($products, $category, $sort)
    {
        $page = $this->getPage('catalog');

        return view('catalog', compact('page', 'products', 'sort', 'category'));
    }
}
