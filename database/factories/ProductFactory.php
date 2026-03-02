<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Snatched Cargo Pants', 'Glow-Up Vitamin C Serum', 'Main Character Sunglasses', 
            'That Girl Tote Bag', 'Viral Lip Oil', 'Y2K Chunky Sneakers'
        ]) . ' - ' . $this->faker->word();

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name . '-' . $this->faker->unique()->numberBetween(1, 1000)),
            'description' => "Literally obsessed with this. " . $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 10, 150),
            'image_url' => 'https://picsum.photos/seed/'.$this->faker->word.'/400/500',
            'is_trending' => $this->faker->boolean(30),
        ];
    }
}
