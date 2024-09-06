<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Callback>
 */
class CallbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' =>
                '+7' . $this->faker->numberBetween(9000000000, 9999999999),
            'message' => $this->faker->sentence(rand(3, 30)),
            'user_hash' => $this->faker->md5(),
            'is_archived' => $this->faker->boolean(10),
        ];
    }
}
