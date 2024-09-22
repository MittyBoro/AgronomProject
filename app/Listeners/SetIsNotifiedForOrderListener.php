<?php

namespace App\Listeners;

use App\Notifications\NewOrderStatusNotification;
use Illuminate\Notifications\Events\NotificationSent;

class SetIsNotifiedForOrderListener
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
    public function handle(NotificationSent $event): void
    {
        /**
         * @var NewOrderStatusNotification $notification
         */
        $notification = $event->notification;

        if (property_exists($notification, 'order')) {
            $order = $notification->order;

            dispatch(fn() => $order->update(['is_notified' => false]));
        }
    }
}
