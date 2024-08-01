<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $total = $this->cartService->getCartTotal();

        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $variationIds = $request->variation_ids ?? [];
        $quantity = $request->quantity ?? 1;

        $this->cartService->addToCart($product, $variationIds, $quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function remove(Request $request)
    {
        $cartItem = $this->cartService->getCart()->items()->findOrFail($request->cart_item_id);
        $this->cartService->removeFromCart($cartItem);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }

    public function update(Request $request)
    {
        $cartItem = $this->cartService->getCart()->items()->findOrFail($request->cart_item_id);
        $this->cartService->updateQuantity($cartItem, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()->route('cart.index')->with('success', 'Cart cleared');
    }
}
