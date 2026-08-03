<?php

namespace App\Http\Controllers;

use App\Mail\OrderReceipt;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class CheckoutController extends Controller
{
    public function review(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|string|in:cod,online',
            'online_provider' => 'nullable|string|in:gcash,maya,card',
        ]);

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        foreach ($cart as $item) {
            $product = Product::find($item['product_id'] ?? null);
            if (!$product) {
                return redirect()->route('cart.index')->with('error', 'One of the products in your cart is no longer available.');
            }

            $stock = Schema::hasColumn('products', 'quantity')
                ? $product->quantity
                : (Schema::hasColumn('products', 'stock') ? $product->stock : null);

            if ($stock !== null && $stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', "Insufficient stock for {$product->name}. Only {$stock} left.");
            }
        }

        $checkoutData = array_merge($request->only(['name','email','address','city','phone','payment_method','online_provider']), [
            'total' => $total,
            'items' => $cart,
        ]);

        session(['checkout.review' => $checkoutData]);

        return view('product.checkout-review', compact('checkoutData'));
    }

    public function confirm()
    {
        $checkoutData = session('checkout.review');
        if (!$checkoutData) {
            return redirect()->route('checkout.index')->with('error', 'Please complete checkout details first.');
        }

        return view('product.checkout-confirm', compact('checkoutData'));
    }

    public function history()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('product.orders', compact('orders'));
    }

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
        $checkoutData = session('checkout.review');
        if (!$checkoutData) {
            return redirect()->route('checkout.index')->with('error', 'Please complete checkout details first.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name' => $checkoutData['name'],
            'email' => $checkoutData['email'],
            'address' => $checkoutData['address'],
            'city' => $checkoutData['city'],
            'phone' => $checkoutData['phone'],
            'total_amount' => $checkoutData['total'],
            'status' => 'completed',
            'items_json' => json_encode($checkoutData['items']),
        ]);

        foreach ($checkoutData['items'] as $item) {
            $product = Product::find($item['product_id'] ?? null);
            if (!$product) {
                continue;
            }

            if (Schema::hasColumn('products', 'quantity')) {
                $product->decrement('quantity', $item['quantity']);
            } elseif (Schema::hasColumn('products', 'stock')) {
                $product->decrement('stock', $item['quantity']);
            }

            $product->refresh();
            if (($product->quantity ?? $product->stock ?? 1) <= 0) {
                $product->is_sold_out = true;
                $product->save();
            }
        }

        Mail::to($order->email)->send(new OrderReceipt($order));

        session()->forget('cart');
        session()->forget('checkout.review');

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully! 🛍️');
    }

    public function success(Order $order)
    {
        return view('product.checkout-success', compact('order'));
    }
}
