<?php

namespace App\Services\Cart;

use App\Enums\CartTypeEnum;

class CartService extends BaseCartService
{
    public function __construct()
    {
        parent::__construct(CartTypeEnum::Cart);
    }
}
