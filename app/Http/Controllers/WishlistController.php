<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display the wishlist page.
     */
    public function index()
    {
        $wishlist = session()->get('wishlist', []);

        return view('product.wishlist', compact('wishlist'));
    }

    /**
     * Toggle a product in the wishlist.
     */
    public function toggle(Request $request, Product $product)
    {
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$product->id])) {
            unset($wishlist[$product->id]);
            $message = 'Removed from wishlist.';
        } else {
            $wishlist[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
            ];
            $message = 'Added to wishlist.';
        }

        session()->put('wishlist', $wishlist);

        return redirect()->back()->with('success', $message);
    }

    /**
     * Move a product from wishlist to cart.
     */
    public function moveToCart(Product $product)
    {
        $wishlist = session()->get('wishlist', []);

        if (!isset($wishlist[$product->id])) {
            return redirect()->back()->with('error', 'Item not found in wishlist.');
        }

        $cart = session()->get('cart', []);
        $cartKey = $product->id . md5($product->image_url);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image_url,
            ];
        }

        session()->put('cart', $cart);
        unset($wishlist[$product->id]);
        session()->put('wishlist', $wishlist);

        return redirect()->route('cart.index')->with('success', 'Moved to cart successfully!');
    }
}
