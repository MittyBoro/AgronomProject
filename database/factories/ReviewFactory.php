<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $product = Product::isPublished()->inRandomOrder()->first();

        return [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'is_approved' => fake()->boolean(80),
            'rating' => fake()->numberBetween(1, 5),
            'name' => $user->name,
            'comment' => fake()->sentence(rand(3, 10)),
        ];
    }
}
