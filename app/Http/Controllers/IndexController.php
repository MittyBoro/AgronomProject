<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

final class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $page = $this->getPage('/');

        // лучшие отзывы
        $reviews = Review::selectPublic()
            ->with('product')
            ->isPinned()
            ->limit(4)
            ->get();

        // популярные товары
        $popularProducts = Product::selectPublic()->latest()->limit(4)->get();

        // скидки
        $discountProducts = Product::selectPublic()
            ->orderBy('discount', 'desc')
            ->limit(4)
            ->get();

        // последние статьи
        $articles = Article::selectPublic()->latest()->limit(3)->get();

        return view(
            'index',
            compact(
                'page',
                'reviews',
                'popularProducts',
                'discountProducts',
                'articles',
            ),
        );
    }
}
