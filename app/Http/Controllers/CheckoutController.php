<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // 2. Calculate cart total
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 3. Save order to database
        $userId = Auth::check() ? Auth::id() : null;
        
        Order::create([
            'user_id' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
            'total_amount' => $total,
            'status' => 'completed',
            'items_json' => json_encode($cart),
        ]);
        
        // 4. Clear the cart session after successful order
        session()->forget('cart');

        // 5. Redirect to a success page or dashboard
        return redirect()->route('dashboard')->with('success', 'Order placed successfully! 🛍️');
    }
}