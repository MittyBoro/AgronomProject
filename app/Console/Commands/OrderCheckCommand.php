<?php

namespace App\Console\Commands;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Services\Payment\PaymentService;
use Illuminate\Console\Command;
use Throwable;

class OrderCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверка оплаты';

    /**
     * Выбрать всех, у кого не выставился уровень
     * или последний заказ был обновлен менее 3 часов назад (с запасом)
     */
    public function handle(): void
    {
        Order::where('status', OrderStatusEnum::Pending)
            ->where('created_at', '<=', now()->subMinutes(5))
            ->latest()
            ->cursor()
            ->each(function (Order $order): void {
                $this->info('');
                $this->info('Проверка оплаты #' . $order->id);
                try {
                    $payment = PaymentService::set($order);
                    $payment->check();
                    $this->info('Ok');
                } catch (Throwable $th) {
                    $this->error($th->getMessage());
                }
            });
    }
}
