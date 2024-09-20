<?php

namespace App\Services\Payment;

use App\Contracts\PaymentInterface;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Exception;
use Throwable;
use YooKassa\Client;
use YooKassa\Model\Notification\NotificationFactory;

class YooKassaService implements PaymentInterface
{
    private $client;

    public function __construct(private Order $order)
    {
        $this->client = new Client();
        $this->client->setAuth(
            config('shop.drivers.yookassa.shop_id'),
            config('shop.drivers.yookassa.secret_key'),
        );
    }

    public function charge(): void
    {
        $this->order->setStatus(OrderStatusEnum::Pending);

        try {
            $idempotenceKey = uniqid('', true);

            $paymentArray = [
                'amount' => [
                    'value' => $this->order->getAmount(),
                    'currency' => \YooKassa\Model\CurrencyCode::RUB,
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => $this->order->getReturnUrl(),
                ],
                'capture' => true,
                'description' => $this->order->getDescription(),
                'metadata' => [
                    'order_id' => $this->order->getId(),
                ],
                'receipt' => [
                    'customer' => [
                        'full_name' => $this->order->getCustomerName(),
                        'email' => $this->order->getCustomerEmail(),
                        'phone' => $this->order->getCustomerPhone(),
                    ],
                    'items' => $this->getItemsArray(),
                ],
            ];

            $response = $this->client->createPayment(
                $paymentArray,
                $idempotenceKey,
            );

            $id = $response->getId();

            if (!$id) {
                throw new Exception('YooKassa id не получен');
            }

            $this->order->setPaymentData([
                'id' => $id,
                'url' => $response->getConfirmation()->getConfirmationUrl(),
            ]);
        } catch (Throwable $e) {
            logger()->error(
                'Error in YooKassaPayment::charge(): ' . $e->getMessage(),
            );
            throw $e;
        }
    }

    private function getItemsArray()
    {
        foreach ($this->order->getItems() as $item) {
            /**
             * @var $item OrderItem
             */
            $description = $item->getName();
            $items4Kassa[] = [
                'description' => $description,
                'quantity' => $item->getQuantity(),
                'amount' => [
                    'value' => $item->getAmount(),
                    'currency' => \YooKassa\Model\CurrencyCode::RUB,
                ],
                'vat_code' => '1',
                'payment_mode' => 'full_payment',
                'payment_subject' => 'commodity',
            ];
        }

        if ($this->order->getDeliveryAmount()) {
            $items4Kassa[] = [
                'description' => 'Доставка',
                'quantity' => 1,
                'amount' => [
                    'value' => $this->order->getDeliveryAmount(),
                    'currency' => \YooKassa\Model\CurrencyCode::RUB,
                ],
                'vat_code' => '1',
                'payment_mode' => 'full_payment',
                'payment_subject' => 'service',
            ];
        }

        return $items4Kassa;
    }

    public function check()
    {
        $paymentId = $this->order->getPaymentData()['id'] ?? '';

        try {
            $payment = $this->client->getPaymentInfo($paymentId);
            $this->setStatusByKey($payment->getStatus());
        } catch (Exception $e) {
            return $this->order->setStatus(OrderStatusEnum::Canceled);
        }
    }

    public function webhook()
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        if (
            !$requestBody ||
            !is_array($requestBody) ||
            !isset($requestBody['event'])
        ) {
            throw new Exception('Ошибка получения webhook данных');
        }

        try {
            $factory = new NotificationFactory();
            $notification = $factory->factory($requestBody);
            $payment = $notification->getObject();
        } catch (Exception $e) {
            throw new Exception('Ошибка получения webhook данных #2');
        }

        $this->order = Order::find($payment->metadata['order_id']);

        $this->setStatusByKey($payment->status);
    }

    public function refund()
    {
        try {
            $this->client->createRefund(
                [
                    'payment_id' =>
                        $this->order->getPaymentData()['id'] ?? null,
                    'amount' => [
                        'value' => $this->order->getAmount(),
                        'currency' => \YooKassa\Model\CurrencyCode::RUB,
                    ],
                ],
                uniqid('', true),
            );
            return $this->order->setStatus(OrderStatusEnum::Refunded);
        } catch (Throwable $th) {
            logger()->error(
                'Error in YooKassaPayment::refund(): ' . $th->getMessage(),
            );
        }
    }

    private function setStatusByKey($key): void
    {
        switch ($key) {
            case 'succeeded':
                $status = OrderStatusEnum::Paid;
                break;
            case 'canceled':
                $status = OrderStatusEnum::Canceled;
                break;
            default:
                $status = OrderStatusEnum::Pending;
                break;
        }
        $this->order->setStatus($status);
    }
}
