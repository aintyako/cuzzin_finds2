<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CartController extends Controller
{
    /**
     * Display the cart page with the total bill calculation.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Calculate the total bill
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('product.cart', compact('cart', 'total'));
    }

    /**
     * Add a product to the session-based cart.
     * Updated to handle specific color/image selection.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->is_sold_out || (Schema::hasColumn('products', 'quantity') && $product->quantity <= 0) || (Schema::hasColumn('products', 'stock') && $product->stock <= 0)) {
            return redirect()->back()->with('error', 'This product is sold out and cannot be added to the cart.');
        }
        
        // Check if a specific image was passed from the gallery modal
        // If not, fall back to the default image_url
        $imageToStore = $request->query('selected_image', $product->image_url);

        $cart = session()->get('cart', []);

        // Create a unique key for the cart item based on product ID and image path
        // This allows the same product in different colors to be separate line items
        $cartKey = $id . md5($imageToStore);

        if(isset($cart[$cartKey])) {
            // If this specific color is already in cart, increment quantity
            $cart[$cartKey]['quantity']++;
        } else {
            // Add new specific item to cart array
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $imageToStore // Save the chosen color image path here
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Remove an item from the cart.
     * Updated to use the unique cartKey.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        // Note: $id here will now be the $cartKey sent from the view
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}