<?php

namespace App\Observers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $order->decrementProductStock();
        $order->decrementCouponCount();
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            // в очередь, иначе рекурсия
            dispatch(fn() => $order->update(['is_notified' => true]));

            $oldStatus = $order->getOriginal('status');

            switch ($order->status) {
                case OrderStatusEnum::Completed:
                    // Начисляем бонусы при закрытии заказа
                    $order->earnBonuses();

                    break;
                case OrderStatusEnum::Canceled:
                case OrderStatusEnum::Refunded:
                    // Удаляем бонусы при отмене заказа (начисленные и потраченные)
                    $order->bonuses()->delete();

                    // Возврат товаров
                    if (
                        !in_array($oldStatus, [
                            OrderStatusEnum::Canceled,
                            OrderStatusEnum::Refunded,
                        ])
                    ) {
                        $order->decrementProductStock(-1);
                        $order->decrementCouponCount(-1);
                    }

                    break;

                default:
                    /**
                     * Убираем товары, если статус изменили с Canceled или Refunded
                     * то есть заказ возвращён «в работу»
                     */
                    if (
                        in_array($oldStatus, [
                            OrderStatusEnum::Canceled,
                            OrderStatusEnum::Refunded,
                        ])
                    ) {
                        $order->decrementProductStock();
                        $order->decrementCouponCount();
                    }

                    break;
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
