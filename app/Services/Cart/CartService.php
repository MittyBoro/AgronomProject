<?php

namespace App\Services\Cart;

use App\Enums\CartTypeEnum;
use App\Models\CartItem;

class CartService extends BaseCartService
{
    public function __construct()
    {
        parent::__construct(CartTypeEnum::Cart);
    }

    public function checkStock(): bool
    {
        $items = $this->items();

        $isChanged = false;

        $items->each(function (CartItem $item) use (&$isChanged): void {
            if ($item->variation) {
                $stock = $item->variation->stock;
            } else {
                $stock = $item->product->stock;
            }

            if ($item->quantity > $stock) {
                $isChanged = true;
                $item->quantity = $stock;
                $item->save();
            }
        });

        return $isChanged;
    }
}
