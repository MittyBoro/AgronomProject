<?php

namespace Database\Factories;

use App\Enums\VariationGroupTypeEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VariationGroup>
 */
class VariationGroupFactory extends BaseFactory
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
