<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    public function test_placing_order_saves_to_database(): void
    {
        // Create a test product
        $category = Category::create(['name' => 'Test', 'slug' => 'test']);
        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'category_id' => $category->id,
            'price' => 99.99,
            'quantity' => 10,
            'description' => 'Test',
            'image_url' => '/test.jpg',
        ]);

        // Simulate cart in session
        session(['cart' => [
            'test-key' => [
                'name' => 'Test Product',
                'price' => 99.99,
                'quantity' => 2,
                'image' => '/test.jpg',
            ]
        ]]);

        // Place order
        $response = $this->post(route('order.place'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'address' => '123 Main St',
            'city' => 'Test City',
            'phone' => '555-1234',
        ]);

        $response->assertRedirect();
        
        // Verify order was saved
        $this->assertDatabaseHas('orders', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'total_amount' => 199.98,
        ]);
    }

    public function test_conversion_rate_calculates_correctly(): void
    {
        // Create test data
        Category::create(['name' => 'Test', 'slug' => 'test']);
        
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => "Product $i",
                'slug' => "product-$i",
                'category_id' => 1,
                'price' => 10.00,
                'quantity' => 5,
                'description' => 'Test',
                'image_url' => '/test.jpg',
            ]);
        }

        // Create 5 orders
        for ($i = 0; $i < 5; $i++) {
            Order::create([
                'name' => "Customer $i",
                'email' => "customer$i@example.com",
                'address' => '123 Main',
                'city' => 'Test',
                'phone' => '555-1234',
                'total_amount' => 99.99,
                'status' => 'completed',
            ]);
        }

        // Conversion rate should be (5 orders / 10 products) * 100 = 50%
        $response = $this->get(route('dashboard'));
        $response->assertViewHas('conversionRate', 50);
    }
}
