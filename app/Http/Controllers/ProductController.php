<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

final class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $slug)
    {
        $product = Product::whereSlug($slug)
            ->with('media', 'categories')
            ->selectPublic(full: true)
            ->firstOrFail();

        $reviews = Review::selectPublic()
            ->where('product_id', $product->id)
            ->paginate(12);

        $similar = $product->categories
            ->first()
            ?->products()
            ->selectPublic()
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->inRandomOrder()
            ->get();

        return view('product', compact('product', 'reviews', 'similar'));
    }
}
