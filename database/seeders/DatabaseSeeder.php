<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LoyaltySeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(PropSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(BannerSeeder::class);

        $this->call(VariationGroupSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ReviewSeeder::class);

        $this->call(ArticleSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(CallbackSeeder::class);
    }
}
