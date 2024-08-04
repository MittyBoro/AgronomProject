<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

final class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $slug)
    {
        $product = Product::whereSlug($slug)
            ->selectPublic(full: true)
            ->firstOrFail();

        $similar = $product->categories
            ->first()
            ?->products()
            ->selectPublic()
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->inRandomOrder()
            ->get();
        return view('product', compact('product', 'similar'));
    }
}
