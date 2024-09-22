<?php

namespace App\Notifications;

use App\Models\Callback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCallbackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Callback $callback)
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('На сайте новая заявка')
            ->line('В контактной форме новая заявка')
            ->line('Форма: ' . $this->callback->form)
            ->line('Имя: ' . $this->callback->name)
            ->line('Email: ' . $this->callback->email)
            ->lineIf(
                $this->callback->phone,
                'Телефон: ' . $this->callback->phone,
            )
            ->line('Сообщение:')
            ->line(Markdown::parse('>' . nl2br($this->callback->message)))
            ->action(
                'Перейти к заявке',
                route('filament.theadmin.resources.callbacks.index', [
                    'tableSearch' => $this->callback->id,
                ]),
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
