<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Product;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Attach products to categories
        $categories = Category::all();
        Product::all()->each(function ($product) use ($categories) {
            $product->categories()->attach($categories->random(rand(1, 3))->pluck('uuid'));
        });
    }
}
