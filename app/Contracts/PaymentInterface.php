<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentInterface
{
    public function __construct(Order $order);

    public function charge();

    public function check();

    public function webhook();

    public function refund();
}
