<?php

namespace Database\Seeders;

use App\Models\Prop;
use Illuminate\Database\Seeder;

class PropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // 'delivery_price'
            [
                'type' => 'number',
                'key' => 'delivery_price',
                'group' => 'Платежи',
                'title' => 'Стоимость доставки',
            ],
            // 'free_delivery_min_amount'
            [
                'type' => 'number',
                'key' => 'free_delivery_min_amount',
                'group' => 'Платежи',
                'title' => 'Минимальная сумма для бесплатной доставки',
            ],
            // 'max_bonuses_spend_percent'
            [
                'type' => 'number',
                'key' => 'max_bonuses_spend_percent',
                'group' => 'Платежи',
                'title' => 'Максимальный процент оплаты бонусами',
            ],

            // 'code_before_head'
            [
                'type' => 'text',
                'key' => 'code_before_head',
                'group' => 'Коды',
                'title' => 'HTML коды перед </head>',
            ],
            // 'code_before_body'
            [
                'type' => 'text',
                'key' => 'code_before_body',
                'group' => 'Коды',
                'title' => 'HTML коды перед </body>',
            ],
        ];

        Prop::upsert($data, uniqueBy: ['key'], update: ['type']);
    }
}
