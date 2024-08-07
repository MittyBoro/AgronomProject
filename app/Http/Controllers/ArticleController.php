<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

final class ArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $page = $this->getPage('articles');

        $articles = Article::selectPublic()->paginate(8);

        return view('articles', compact('page', 'articles'));
    }

    /**
     * Handle the incoming request.
     */
    public function show(Request $request, $slug)
    {
        $article = Article::whereSlug($slug)
            ->selectPublic(full: true)
            ->firstOrFail();

        $similar = Article::selectPublic()->where('id', '!=', $article->id)->inRandomOrder()->limit(3)->get();

        return view('article', compact('article', 'similar'));
    }
}
