<?php

namespace App\Listeners;

use App\Enums\OrderStatusEnum;
use App\Events\OrderStatusChangedEvent;
use App\Notifications\NewOrderStatusNotification;

class NotifyClientOfOrderStatusChangeListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusChangedEvent $event): void
    {
        /** @var \App\Models\Order $order */
        $order = $event->order;

        if (
            in_array($order->status, [
                OrderStatusEnum::Shipped,
                OrderStatusEnum::Completed,
                OrderStatusEnum::Canceled,
                OrderStatusEnum::Refunded,
            ])
        ) {
            $order->user
                ->notify(new NewOrderStatusNotification($order))
                ?->delay(now()->addMinutes(3));
        }
    }
}
