<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;

class WebhookController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function handle($paymentMethod)
    {
        if (!in_array($paymentMethod, array_keys(config('shop.drivers')))) {
            return abort(403);
        }

        $payment = PaymentService::set(method: $paymentMethod);

        return $payment->webhook();
    }
}
