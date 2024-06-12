<?php

namespace Database\Factories;

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
        return [
            'product_name' => fake()->word(),
            'selling_price' => fake()->numberBetween(100, 2000),
            'stock' => fake()->numberBetween(1, 100),
            'color' => fake()->colorName(),
            'image' => fake()->imageUrl(),
        ];
    }
}
