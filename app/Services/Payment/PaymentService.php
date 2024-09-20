<?php

namespace App\Services\Payment;

use App\Contracts\PaymentInterface;
use App\Models\Order;
use Exception;

class PaymentService
{
    public static function set(
        ?Order $order = null,
        ?string $method = null,
    ): PaymentInterface {
        $paymentMethod = $method ?? $order->getPaymentMethod();

        $modelClass = config('shop.drivers.' . $paymentMethod . '.class');

        if (!class_exists($modelClass)) {
            throw new Exception('Payment driver not found');
        }

        return new $modelClass($order ?? new Order());
    }
}
