<?php

namespace App\Contracts;

use App\Enums\OrderStatusEnum;
use Illuminate\Support\Collection;

interface OrderInterface
{
    public function getPaymentMethod(): ?string;

    public function getAmount(): float;

    public function getDeliveryAmount(): float;

    public function getId(): int|string;

    public function getDescription(): string;

    public function getCustomerName(): string;

    public function getCustomerEmail(): ?string;

    public function getCustomerPhone(): ?string;

    public function getItems(): Collection;

    public function getPaymentData(): array;

    public function setPaymentData(array $values): void;

    public function setStatus(OrderStatusEnum $value): void;

    public function getPaymentUrl(): ?string;

    public function getReturnUrl(): string;

    public function getPaymentService(): PaymentInterface;
}
