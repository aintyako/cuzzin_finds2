<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Keep your Admin User
        User::create([
            'name' => 'Cuzzin Admin',
            'email' => 'admin@cuzzinfinds.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create your REAL categories to match your frontend
        $categories = ['Clothes', 'Beauty', 'Jewellery', 'Sale'];
        foreach ($categories as $cat) {
            Category::create(['name' => $cat, 'slug' => Str::slug($cat)]);
        }

        // We deleted the Product::factory(40)->create(); line! Zero products now.
    }
}