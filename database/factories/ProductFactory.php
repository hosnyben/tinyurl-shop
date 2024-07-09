<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random category uuid
        $category = Category::inRandomOrder()->first();

        return [
            'uuid' => fake()->uuid,
            'name' => fake()->sentence(2),
            'description' => fake()->text,
            'price' => fake()->numberBetween(1000, 100000),
            'top' => fake()->boolean,
            'deleted' => fake()->boolean
        ];
    }
}
