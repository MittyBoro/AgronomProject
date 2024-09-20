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

    public function check()
    {
        //
    }

    public function webhook()
    {
        //
    }

    public function refund()
    {
        $this->order->setStatus(OrderStatusEnum::Refunded);
    }
}
