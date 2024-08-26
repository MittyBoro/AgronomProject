<?php

namespace Database\Factories;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'TEST_' . rand(1000, 9999),
            'percentage' => rand(1, 10),
            'count' => rand(1, 10),
            'is_active' => rand(0, 1),
            'expires_at' => rand(0, 1) ? now()->addDays(30) : null,
        ];
    }
}
