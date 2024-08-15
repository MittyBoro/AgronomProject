<?php

namespace App\Livewire\Product;

use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Detail extends Component
{
    public array $product;

    public string $description;

    public string $grouped_variations;

    #[Validate('required|integer|min:1|max:99')]
    public int $count = 1;

    #[Renderless]
    public ?int $activeVariationId = null;

    public function mount(): void
    {
        $this->activeVariationId =
            $this->product['variations'][0]['id'] ?? null;
    }

    #[Computed]
    public function activeVariation(): ?array
    {
        if (!empty($this->product['variations'])) {
            return Arr::first(
                $this->product['variations'],
                fn(array $value) => $this->activeVariationId === $value['id'],
            );
        }

        return null;
    }

    #[Computed]
    public function stock(): ?int
    {
        return !empty($this->activeVariation)
            ? $this->activeVariation['stock']
            : $this->product['stock'];
    }

    #[Computed]
    public function price(): ?int
    {
        return $this->product['price'] +
            ($this->activeVariation['price_modifier'] ?? 0);
    }

    #[Computed]
    public function totalPrice(): ?int
    {
        $discountFactor = 1 - $this->product['discount'] / 100;

        return $this->product['total_price'] +
            ($this->activeVariation['price_modifier'] ?? 0) * $discountFactor;
    }

    #[Renderless]
    public function incrementCount($v = 1): void
    {
        $this->count += $v;
        if ($this->count > $this->stock) {
            $this->count = $this->stock;
        }
        if ($this->count < 1) {
            $this->count = 1;
        }
    }
}
