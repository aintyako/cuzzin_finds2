<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page with cart totals.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // If cart is empty, redirect back to cart page
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('product.checkout', compact('total', 'cart'));
    }

    /**
     * Handle the form submission (Place Order).
     */
    public function placeOrder(Request $request)
    {
        // 1. Validate the input from your checkout form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
        ]);

        // 2. Logic to save to database would go here (Order::create...)
        
        // 3. Clear the cart session after successful order
        session()->forget('cart');

        // 4. Redirect to a success page or dashboard
        return redirect()->route('dashboard')->with('success', 'Order placed successfully! 🛍️');
    }
}