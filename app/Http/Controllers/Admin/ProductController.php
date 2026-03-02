<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage; // <-- Make sure to add this import
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Show the "Add New Product" form
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Save the newly uploaded product to the database
    public function store(Request $request)
    {
        // 1. Validate the form data (Updated for multiple images)
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'images' => 'required|array', // Must be an array of files
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Validate each file in the array
        ]);

        // Get the first image to save as the primary 'image_url' (keeps your current front-end working)
        $firstImagePath = $request->file('images')[0]->store('products', 'public');

        // 2. Create the product in the database FIRST so we have its ID
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . uniqid()),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => '/storage/' . $firstImagePath, // Save the first image as the main thumbnail
            'is_trending' => $request->has('is_trending'),
        ]);

        // 3. Save ALL uploaded images to the new product_images table
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store each image
                $path = $image->store('products', 'public');
                
                // Save to the database
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => '/storage/' . $path
                ]);
            }
        }

        // 4. Send them back to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Product added successfully with multiple images! 🎉');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Fetch categories for the edit dropdown
        $categories = Category::all();
        
        // Return the edit view and pass the specific product to it
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validate the text inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        // 2. Update the product in the database
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'is_trending' => $request->has('is_trending') ? 1 : 0,
        ]);

        // 3. Send back to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Product updated successfully! ✨');
    }

    /**
     * Toggle the "Sold Out" status of a product.
     */
    public function toggleStock(Product $product)
    {
        // Flip the boolean value (if true, make false. If false, make true)
        $product->is_sold_out = !$product->is_sold_out;
        $product->save();

        // Check the new status to send the correct success message
        $status = $product->is_sold_out ? 'Sold Out' : 'In Stock';

        return redirect()->back()->with('success', "Product is now marked as {$status}! 📦");
    }

    /**
     * Remove the specified product from the database.
     */
    public function destroy(Product $product)
    {
        // 1. Delete the main thumbnail image from storage
        if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
            $mainImagePath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($mainImagePath);
        }

        // 2. Delete all extra images from storage
        foreach ($product->images as $image) {
            if (str_starts_with($image->image_path, '/storage/')) {
                $path = str_replace('/storage/', '', $image->image_path);
                Storage::disk('public')->delete($path);
            }
        }

        // 3. Delete the product from the database
        // Note: Thanks to the 'cascadeOnDelete()' in your migration, 
        // this will automatically delete the related rows in the product_images table too!
        $product->delete();

        // 4. Redirect back with a success message
        return redirect()->back()->with('success', 'Product completely deleted! 🗑️');
    }
}