<?php

namespace App\Observers;

use App\Enums\CartTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Events\OrderStatusChangedEvent;
use App\Models\Cart;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // товары добавятся сразу, но после created
        dispatch(fn() => $order->decrementProductStock())->afterResponse();

        // уменьшаем количество купонов
        $order->decrementCouponCount();
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            // в очередь, иначе рекурсия
            dispatch(fn() => $order->update(['is_notified' => false]));

            $oldStatus = $order->getOriginal('status');

            // Уведомляем об изменении статуса
            switch ($order->status) {
                case OrderStatusEnum::Paid:
                case OrderStatusEnum::Processing:
                case OrderStatusEnum::Shipped:
                case OrderStatusEnum::Completed:
                case OrderStatusEnum::Canceled:
                case OrderStatusEnum::Refunded:
                    event(new OrderStatusChangedEvent($order));
                    break;
            }

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

                    if ($order->status === OrderStatusEnum::Refunded) {
                        $order->getPaymentService()->refund();
                    }

                    break;
                // оплаченный заказ переводим в "в работу"
                case OrderStatusEnum::Paid:
                    $order->status = OrderStatusEnum::Processing;
                    $order->save();

                    // Очищаем корзину
                    dispatch(
                        fn() => Cart::query()
                            ->where('type', CartTypeEnum::Cart)
                            ->where('user_id', $order->user_id)
                            ->delete(),
                    );

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
        $order->decrementProductStock(-1);
        $order->decrementCouponCount(-1);
        $order->bonuses()->delete();
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
