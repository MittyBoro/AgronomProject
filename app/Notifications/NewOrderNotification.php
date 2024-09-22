<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
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
        $orderDetails = View::make('emails.order-details', [
            'order' => $this->order,
        ])->render();
        $orderDetails = str_replace("\n", '', $orderDetails);
        $orderDetails = new HtmlString($orderDetails);

        $name =
            trim($notifiable->first_name . ' ' . $notifiable->middle_name) ??
            $notifiable->name;

        return (new MailMessage())
            ->greeting('Здравствуйте, ' . $name . '!')
            ->subject('Принят новый заказ #' . $this->order->id)
            ->line(Markdown::parse('## Новый заказ #' . $this->order->id))
            ->line($orderDetails)
            ->action(
                'Перейти к заказу',
                $notifiable->is_admin
                    ? route('filament.theadmin.resources.orders.index', [
                        'tableSearch' => $this->order->id,
                    ])
                    : route('profile.orders.show', $this->order->id),
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
