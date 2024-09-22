<?php

namespace App\Listeners;

use App\Enums\OrderStatusEnum;
use App\Events\OrderStatusChangedEvent;
use App\Models\User;
use App\Notifications\NewOrderNotification;

class NotifyOrderCreatedListener
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

        if ($order->status !== OrderStatusEnum::Paid) {
            return;
        }

        // уведомляем админов
        $toNotify = User::query()->isAdmin()->isNotifiable()->get();
        foreach ($toNotify as $user) {
            $user->notify(new NewOrderNotification($order));
        }

        $order->user->notify(new NewOrderNotification($order));
    }
}
