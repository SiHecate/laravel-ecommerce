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
            'title' => fake()->sentence(45),
            'description' => fake()->sentence(45),
            'price' => fake()->Str::random(3),
            'stock' => fake()->Str::random(2),
            'tag' => fake()->sentence(6),
        ];
    }
}
