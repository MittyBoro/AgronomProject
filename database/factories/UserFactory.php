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

        $name = $this->faker->name($gender);
        $nameArray = explode(' ', $name);

        return [
            'name' => $nameArray[0] . ' ' . mb_substr($nameArray[2], 0, 1) . '. ',
            'first_name' => $nameArray[0],
            'middle_name' => $nameArray[1],
            'last_name' => $nameArray[2],
            'birthday' => $this->faker->dateTimeBetween('-70 years', '-18 years'),
            'gender' => $gender,
            'phone' => $this->faker->e164PhoneNumber(),
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
            fn (array $attributes) => [
                'email_verified_at' => null,
            ],
        );
    }
}
