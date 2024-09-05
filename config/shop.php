<?php

return [
    /**
     * Предупреждение о недостатке на складе
     */
    'warning_stock' => (int) env('SHOP_WARNING_STOCK', 30),

    /**
     * Максимальная трата бонусов за покупку, %
     */
    'max_spend_bonuses' => (int) env('SHOP_MAX_SPEND_BONUSES', 30),
];
