<?php

namespace App\Listeners;

use App\Events\ReviewCreatedEvent;
use App\Models\User;
use App\Notifications\NewReviewNotification;

class NotifyReviewCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Уведомить админа о создании нового отзыва
     */
    public function handle(ReviewCreatedEvent $event): void
    {
        /** @var \App\Models\Review $review */
        $review = $event->review;

        $toNotify = User::query()->isAdmin()->isNotifiable()->get();
        foreach ($toNotify as $user) {
            $user->notify(new NewReviewNotification($review));
        }
    }
}
