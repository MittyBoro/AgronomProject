<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    use LabelsTrait;

    case Pending = 'pending';
    case Paid = 'paid';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Ожидает оплаты',
            self::Paid => 'Оплачен',
            self::Processing => 'Ожидает отправки',
            self::Shipped => 'Отправлен',
            self::Completed => 'Завершен',

            self::Canceled => 'Отменен',
            self::Refunded => 'Средства возвращены',
        };
    }
}
