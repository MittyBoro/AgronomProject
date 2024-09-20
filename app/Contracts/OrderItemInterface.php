<?php

namespace App\Contracts;

interface OrderItemInterface
{
    public function getAmount();

    public function getName();

    public function getQuantity();
}
