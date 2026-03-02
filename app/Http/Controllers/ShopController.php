<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Handle the main Landing Page (Hero Section Only)
     */
    public function index()
    {
        // The landing page no longer needs to fetch products as per your request
        return view('welcome');
    }

    /**
     * Handle the dedicated Shop/Catalog page (Shows all products)
     */
    public function shop(Request $request)
    {
        // 1. Logic for products (with optional search/filter)
        $query = Product::with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        // 2. Logic for "New Arrivals" section on the shop page
        $latestProducts = Product::with('category')->latest()->take(8)->get();

        // 3. Get categories for filters
        $categories = Category::all();

        // Returns the dedicated product index view
        return view('product.index', compact('products', 'latestProducts', 'categories'));
    }

    /**
     * Handle the dedicated Clothes page
     */
    public function clothesPage()
    {
        // 1. Get ONLY products in the 'clothes' category for the main section
        $products = Product::whereHas('category', function($q) {
            $q->where('slug', 'clothes');
        })->latest()->paginate(12);

        // 2. FIX: Get the latest 4 arrivals specifically for CLOTHES only
        $latestProducts = Product::whereHas('category', function($q) {
            $q->where('slug', 'clothes');
        })->with('category')->latest()->take(4)->get();

        // 3. Pass categories in case the layout or filters need them
        $categories = Category::all();

        // Points to: resources/views/product/clothes.blade.php
        return view('product.clothes', compact('products', 'latestProducts', 'categories'));
    }

    /**
     * Handle the dedicated Skincare page
     */
    public function skincarePage()
    {
        // 1. FIX: Changed 'skincare' to 'beauty' to perfectly match your database category
        $products = Product::whereHas('category', function($q) {
            $q->where('slug', 'beauty'); 
        })->latest()->paginate(12);

        // 2. FIX: Get the latest 4 arrivals specifically for BEAUTY only
        $latestProducts = Product::whereHas('category', function($q) {
            $q->where('slug', 'beauty');
        })->with('category')->latest()->take(4)->get();

        // 3. Pass categories in case the layout or filters need them
        $categories = Category::all();

        // Points to: resources/views/product/skincare.blade.php
        return view('product.skincare', compact('products', 'latestProducts', 'categories'));
    }
}