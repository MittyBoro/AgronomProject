<?php

namespace App\Listeners;

use App\Events\CallbackCreatedEvent;
use App\Models\User;
use App\Notifications\NewCallbackNotification;

class NotifyCallbackCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Уведомить админа о создании обращения
     */
    public function handle(CallbackCreatedEvent $event): void
    {
        /** @var \App\Models\Callback $callback */
        $callback = $event->callback;

        $toNotify = User::query()->isAdmin()->isNotifiable()->get();
        foreach ($toNotify as $user) {
            $user->notify(new NewCallbackNotification($callback));
        }
    }
}
