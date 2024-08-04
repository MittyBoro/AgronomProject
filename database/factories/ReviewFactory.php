<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends BaseFactory
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
            'is_pinned' => $this->faker->boolean(30),
            'is_approved' => $this->faker->boolean(80),
            'rating' => $this->faker->numberBetween(1, 5),
            'name' => $user->name,
            'comment' => $this->faker->sentence(rand(3, 10)),
        ];
    }
}
