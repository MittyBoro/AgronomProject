<?php

namespace App\Enums;

enum CartTypeEnum: string
{
    use LabelsTrait;

    case Cart = 'cart';
    case Wishlist = 'wishlist';
    case Compare = 'compare';
}
