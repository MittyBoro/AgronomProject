<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        $this->order->refresh();
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
    public function toMail(User $notifiable): MailMessage
    {
        $name =
            trim($notifiable->first_name . ' ' . $notifiable->middle_name) ??
            $notifiable->name;

        $subject = 'Статус заказа #' . $this->order->id . ' изменился';

        return (new MailMessage())
            ->greeting('Здравствуйте, ' . $name . '!')
            ->subject($subject)
            ->line(
                Markdown::parse(
                    '## Статус заказа #' . $this->order->id . ' изменился',
                ),
            )
            ->line(
                Markdown::parse(
                    'Новый статус: **' . $this->order->status->label() . '**',
                ),
            )
            ->line('')
            ->lineIf(
                $this->order->delivery_comment,
                'Комментарий: ' . $this->order->delivery_comment,
            )
            ->action(
                'Перейти к заказу',
                route('profile.orders.show', $this->order->id),
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

    public function shouldSend(object $notifiable, string $channel): bool
    {
        $this->order->refresh();

        return !$this->order->is_notified;
    }
}
