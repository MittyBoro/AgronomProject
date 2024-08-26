<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends BaseFactory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(GenderEnum::cases())->value;

        $firstName = $this->faker->firstName($gender);
        $lastName = $this->faker->lastName($gender);

        return [
            'name' => $firstName . ' ' . mb_substr($lastName, 0, 1) . '. ',
            'first_name' => $firstName,
            'last_name' => $lastName,
            'birthday' => $this->faker->dateTimeBetween(
                '-70 years',
                '-18 years',
            ),
            'gender' => $gender,
            'phone' =>
                '+7' . $this->faker->numberBetween(9000000000, 9999999999),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => (static::$password ??= Hash::make('password')),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'email_verified_at' => null,
            ],
        );
    }
}
