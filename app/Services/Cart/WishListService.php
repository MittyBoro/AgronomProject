<?php

namespace App\Services\Cart;

use App\Enums\CartTypeEnum;

class WishListService extends BaseCartService
{
    private array $productIds = [];

    public function __construct()
    {
        parent::__construct(CartTypeEnum::Wishlist);

        if ($this->cart->exists) {
            $this->productIds = $this->cart
                ->items()
                ->pluck('product_id')
                ->toArray();
        }
    }

    public function inList(int $productId): bool
    {
        return in_array($productId, $this->productIds);
    }

    public function toggle(int $productId): bool
    {
        $this->cart->touch();

        if ($this->inList($productId)) {
            $this->delete($productId);
            $this->productIds = array_diff($this->productIds, [$productId]);
            return false;
        } else {
            $this->add($productId);
            $this->productIds[] = $productId;

            return true;
        }
    }
}
