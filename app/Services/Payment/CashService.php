<?php

namespace App\Services\Payment;

use App\Contracts\PaymentInterface;
use App\Enums\OrderStatusEnum;
use App\Models\Order;

class CashService implements PaymentInterface
{
    public function __construct(private Order $order)
    {
        //
    }

    public function charge(): void
    {
        $this->order->setStatus(OrderStatusEnum::Paid);
    }

    public function check(): void
    {
        //
    }

    public function webhook(): void
    {
        //
    }

    public function refund(): void
    {
        $this->order->setStatus(OrderStatusEnum::Refunded);
    }
}
