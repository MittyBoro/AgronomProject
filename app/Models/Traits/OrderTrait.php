<?php

namespace App\Models\Traits;

use App\Contracts\PaymentInterface;
use App\Enums\OrderStatusEnum;
use App\Services\Payment\PaymentService;
use Illuminate\Support\Collection;

trait OrderTrait
{
    public function getPaymentMethod(): ?string
    {
        return $this->payment_method ?? null;
    }

    public function getAmount(): float
    {
        return $this->total_price;
    }

    public function getDeliveryAmount(): float
    {
        return $this->delivery_price;
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return 'Заказ #' . $this->id;
    }

    public function getCustomerName(): string
    {
        return $this->full_name;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->email;
    }

    public function getCustomerPhone(): ?string
    {
        return $this->phone;
    }

    public function getItems(): Collection
    {
        $this->load('items');

        return $this->items;
    }

    public function getPaymentData(): array
    {
        return $this->payment_data ?? [];
    }

    public function setPaymentData(array $value): void
    {
        $this->payment_data = $this->getPaymentData() + $value;
        $this->save();
    }

    public function setStatus(OrderStatusEnum $status): void
    {
        $this->status = $status;
        $this->save();
    }

    public function getPaymentUrl(): ?string
    {
        return $this->payment_data['url'] ?? $this->getReturnUrl();
    }

    public function getReturnUrl(): string
    {
        return route('profile.orders.show', $this->id);
    }

    public function getPaymentService(): PaymentInterface
    {
        return PaymentService::set($this);
    }
}
