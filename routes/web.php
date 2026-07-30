<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController; // <--- Imported DashboardController
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Shop Routes
|--------------------------------------------------------------------------
*/

// Landing Page (Hero section only)
Route::get('/', [ShopController::class, 'index'])->name('shop.index');

// Dedicated Products Page (Shows the products after clicking "Start Shopping")
Route::get('/catalog', [ShopController::class, 'shop'])->name('shop.catalog');

// The dedicated Clothes category page
Route::get('/clothes', [ShopController::class, 'clothesPage'])->name('product.clothes');

// NEW: The dedicated Skincare category page
Route::get('/skincare', [ShopController::class, 'skincarePage'])->name('product.skincare');

/*
|--------------------------------------------------------------------------
| Cart Management Routes
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/remove-from-cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Checkout Management Routes (New)
|--------------------------------------------------------------------------
*/

// The page where they see the checkout form
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// The action when they click "Place My Order"
Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('order.place');

/*
|--------------------------------------------------------------------------
| Authenticated Dashboard & Profile Routes
|--------------------------------------------------------------------------
*/

// Updated: Route now uses DashboardController to handle dynamic chart data & analytics
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Product Management)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::patch('/products/{product}/toggle-stock', [ProductController::class, 'toggleStock'])->name('products.toggle-stock');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__.'/auth.php';