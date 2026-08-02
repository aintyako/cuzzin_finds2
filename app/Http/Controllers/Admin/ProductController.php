<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Show the "Add New Product" form
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Save the newly uploaded product to the database
     */
    public function store(Request $request)
    {
        // 1. Validate form data
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category'    => 'nullable|string', // Support for string inputs ("Clothes", "Skincare")
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'description' => 'required|string',
            'images'      => 'required|array',
            'images.*'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Resolve Category ID (Handles both dropdown IDs & direct string names)
        $categoryId = $request->category_id;
        if (!$categoryId && $request->filled('category')) {
            $categoryName = $request->category;
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Category::normalizeSlug($categoryName)]
            );
            $categoryId = $category->id;
        }

        // Save first image as primary thumbnail
        $firstImagePath = $request->file('images')[0]->store('products', 'public');

        // 3. Prepare product data
        $productData = [
            'name'        => $request->name,
            'slug'        => Str::slug($request->name . '-' . uniqid()),
            'category_id' => $categoryId,
            'price'       => $request->price,
            'description' => $request->description,
            'image_url'   => '/storage/' . $firstImagePath,
            'is_trending' => $request->has('is_trending'),
        ];

        // Safely set quantity depending on database column name
        if (Schema::hasColumn('products', 'quantity')) {
            $productData['quantity'] = $request->quantity;
        } elseif (Schema::hasColumn('products', 'stock')) {
            $productData['stock'] = $request->quantity;
        }

        // 4. Create the product
        $product = Product::create($productData);

        // 5. Save ALL uploaded images to product_images table
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => '/storage/' . $path
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Product added successfully with multiple images! 🎉');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validate inputs
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category'    => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'description' => 'required|string',
        ]);

        // 2. Resolve Category ID
        $categoryId = $request->category_id;
        if (!$categoryId && $request->filled('category')) {
            $categoryName = $request->category;
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Category::normalizeSlug($categoryName)]
            );
            $categoryId = $category->id;
        }

        // 3. Prepare update payload
        $updateData = [
            'name'        => $request->name,
            'category_id' => $categoryId ?? $product->category_id,
            'price'       => $request->price,
            'description' => $request->description,
            'is_trending' => $request->has('is_trending') ? 1 : 0,
        ];

        // Safely update quantity or stock column
        if (Schema::hasColumn('products', 'quantity')) {
            $updateData['quantity'] = $request->quantity;
        } elseif (Schema::hasColumn('products', 'stock')) {
            $updateData['stock'] = $request->quantity;
        }

        // 4. Update product
        $product->update($updateData);

        return redirect()->route('dashboard')->with('success', 'Product updated successfully! ✨');
    }

    /**
     * Toggle the "Sold Out" status of a product.
     */
    public function toggleStock(Product $product)
    {
        $product->is_sold_out = !$product->is_sold_out;
        $product->save();

        $status = $product->is_sold_out ? 'Sold Out' : 'In Stock';

        return redirect()->back()->with('success', "Product is now marked as {$status}! 📦");
    }

    /**
     * Remove the specified product from the database.
     */
    public function destroy(Product $product)
    {
        // 1. Delete main thumbnail image
        if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
            $mainImagePath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($mainImagePath);
        }

        // 2. Delete additional gallery images
        foreach ($product->images as $image) {
            if (str_starts_with($image->image_path, '/storage/')) {
                $path = str_replace('/storage/', '', $image->image_path);
                Storage::disk('public')->delete($path);
            }
        }

        // 3. Delete product from DB (cascadeOnDelete handles product_images table)
        $product->delete();

        return redirect()->back()->with('success', 'Product completely deleted! 🗑️');
    }
}