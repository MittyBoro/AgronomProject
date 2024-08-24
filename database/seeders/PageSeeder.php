<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            //
            [
                'slug' => '/',
                'title' => 'Главная',
                'blocks' => [
                    [
                        'data' => [
                            'value' => [
                                'home_title' =>
                                    'Тут будет какой-то оффер мол лучшая отрава для огорода',
                                'home_description' =>
                                    'Lorem ipsum dolor sit amet consectetur. Commodo aliquam quam netus augue. Egestas mattis fames orci malesuada.',
                            ],
                        ],
                        'type' => 'key_value',
                    ],
                ],
            ],
            //
            ['slug' => 'catalog', 'title' => 'Каталог'],
            //
            ['slug' => 'loyalty', 'title' => 'Бонусная программа'],
            //
            ['slug' => 'articles', 'title' => 'Статьи'],
            //
            [
                'slug' => 'about',
                'title' => 'О нас',
                'content' => 'Самая классная компания в мире',
                'blocks' => [
                    [
                        'data' => [
                            'value' => [
                                'Преимущество первое',
                                'Преимущество второе',
                                'Преимущество третье',
                                'Преимущество четвёртое',
                            ],
                        ],
                        'type' => 'key_value',
                    ],
                ],
            ],

            //
            [
                'slug' => 'contacts',
                'title' => 'Контакты',
                'blocks' => [
                    [
                        'data' => [
                            'value' => [
                                'schedule' => 'ПН-ПТ 9:00-18:00, СБ 9:00-15:00',
                                'phone_1' => '+71234567890',
                                'phone_2' => null,
                                'phone_3' => null,
                                'email_1' => 'email@example.com',
                                'email_2' => null,
                                'email_3' => null,
                            ],
                        ],
                        'type' => 'key_value',
                    ],
                ],
            ],
            //
            ['slug' => 'privacy', 'title' => 'Политика конфиденциальности'],
            //
            ['slug' => 'payment', 'title' => 'Оплата'],
            //
            ['slug' => 'delivery', 'title' => 'Доставка'],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate($page);
        }
    }
}
