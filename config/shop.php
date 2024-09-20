<?php

return [
    /**
     * Предупреждение о недостатке на складе
     */
    'warning_stock' => (int) env('SHOP_WARNING_STOCK', 30),

    /**
     * Методы оплаты
     * Отображаются те, что есть в списке
     */
    'drivers' => [
        'yookassa' => [
            'class' => App\Services\Payment\YooKassaService::class,

            'shop_id' => env('YOO_SHOP_ID', null),
            'secret_key' => env('YOO_SECRET_KEY', null),
        ],
        'cash' => [
            'class' => App\Services\Payment\CashService::class,
        ],
    ],
];
