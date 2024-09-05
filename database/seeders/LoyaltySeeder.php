<?php

namespace Database\Seeders;

use App\Models\Loyalty;
use Illuminate\Database\Seeder;

class LoyaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'title' => '1 уровень',
                'percentage' => 3,
                'min_order_sum' => 0,
                'description' => 'Выдается после регистрации',
            ],
            [
                'title' => '2 уровень',
                'percentage' => 4,
                'min_order_sum' => 5000,
                'description' => 'Выдается при сумме заказов от 5 000₽',
            ],
            [
                'title' => '3 уровень',
                'percentage' => 5,
                'min_order_sum' => 10000,
                'description' => 'Выдается при сумме заказов от 10 000₽',
            ],
            [
                'title' => '4 уровень',
                'percentage' => 6,
                'min_order_sum' => 20000,
                'description' => 'Выдается при сумме заказов от 20 000₽',
            ],
            [
                'title' => '5 уровень',
                'percentage' => 7,
                'min_order_sum' => 30000,
                'description' => 'Выдается при сумме заказов от 30 000₽',
            ],
            [
                'title' => '6 уровень',
                'percentage' => 8,
                'min_order_sum' => 50000,
                'description' => 'Выдается при сумме заказов от 50 000₽',
            ],
            [
                'title' => '7 уровень',
                'percentage' => 9,
                'min_order_sum' => 75000,
                'description' => 'Выдается при сумме заказов от 75 000₽',
            ],
            [
                'title' => '8 уровень',
                'percentage' => 10,
                'min_order_sum' => 100000,
                'description' => 'Выдается при сумме заказов от 100 000₽',
            ],
        ];

        foreach ($levels as $level) {
            Loyalty::create($level);
        }
    }
}
