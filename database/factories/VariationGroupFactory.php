<?php

namespace Database\Factories;

use App\Enums\VariationGroupTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class VariationGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => VariationGroupTypeEnum::String->value,
            'title' => ucfirst($this->faker->unique()->word()),
        ];
    }
}
