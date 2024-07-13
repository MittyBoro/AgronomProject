<?php

namespace Database\Factories;

use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $variation = Variation::inRandomOrder()->first();
        return [
            'variation_id' => $variation->id,
            'value' =>
                $this->faker->randomDigit() * 100 .
                ($variation->name === 'Вес' ? ' г.' : 'мл.'),
            'price_modifier' => rand(-1, 1) * rand(1, 4) * 100,
            'stock' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
