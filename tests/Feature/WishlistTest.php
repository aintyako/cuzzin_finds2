<?php

namespace Tests\Feature;

use App\Http\Controllers\WishlistController;
use App\Models\Product;
use Illuminate\Http\Request;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    public function test_wishlist_toggle_adds_and_removes_a_product(): void
    {
        $product = new Product([
            'id' => 1,
            'name' => 'Cool Jacket',
            'price' => 49.99,
            'image_url' => '/images/jacket.jpg',
        ]);

        $controller = new WishlistController();

        $response = $controller->toggle(new Request(), $product);
        $wishlist = session('wishlist', []);
        $this->assertSame('Cool Jacket', reset($wishlist)['name']);

        $response = $controller->toggle(new Request(), $product);
        $this->assertSame([], session('wishlist', []));
    }

    public function test_wishlist_page_shows_saved_items(): void
    {
        $product = new Product([
            'id' => 2,
            'name' => 'Glow Serum',
            'price' => 29.90,
            'image_url' => '/images/serum.jpg',
        ]);

        $this->withSession([
            'wishlist' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image_url,
                ],
            ],
        ])->get(route('wishlist.index'))
            ->assertSee('Glow Serum');
    }
}
