<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Review $review)
    {
        $this->review->load('product');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Кто-то оставили новый отзыв')
            ->line('На сайте оставили новый отзыв')
            ->line('Автор: ' . $this->review->name)
            ->lineIf(
                $this->review->product,
                'Товар: ' . $this->review->product->title,
            )
            ->line('Оценка: ' . $this->review->rating)
            ->line('Отзыв:')
            ->line(Markdown::parse('>' . nl2br($this->review->comment)))
            ->line('Вам нужно одобрить или отклонить отзыв.')
            ->action(
                'Перейти к отзыву',
                route(
                    'filament.theadmin.resources.reviews.edit',
                    $this->review->id,
                ),
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
                //
            ];
    }
}
