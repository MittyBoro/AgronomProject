<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'postal_code',
        'city',
        'address',
        'comment',
        'save_info',
        'delivery_comment',
        'coupon_id',
        'shipping_price',
        'price',
        'total_price',
        'payment_method',
        'status',
        'is_archived',
        'is_notified',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'phone' => E164PhoneNumberCast::class . ':RU',
            'save_info' => 'boolean',
            'status' => OrderStatusEnum::class,

            'shipping_price' => 'decimal:2',
            'price' => 'decimal:2',
            'total_price' => 'decimal:2',

            'is_archived' => 'boolean',
            'is_notified' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the coupon that owns the order.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the items that owns the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the bonuses that owns the order.
     */
    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    protected function spentBonuses(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->bonuses->where('amount', '<', 0),
        );
    }

    protected function earnedBonuses(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->bonuses->where('amount', '>', 0),
        );
    }

    protected function spentAmount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->spent_bonuses->sum('amount'),
        );
    }

    protected function earnedAmount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->earned_bonuses->sum('amount'),
        );
    }

    protected function isCompleted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->status === OrderStatusEnum::Completed,
        );
    }

    protected function isCanceled(): Attribute
    {
        return Attribute::make(
            get: fn() => in_array($this->status, [
                OrderStatusEnum::Canceled,
                OrderStatusEnum::Refunded,
            ]),
        );
    }

    protected function discount(): Attribute
    {
        return Attribute::make(get: fn() => $this->total_price - $this->price);
    }

    public function scopeIsActive(Builder $query)
    {
        return $query->whereIn('status', [
            OrderStatusEnum::Pending,
            OrderStatusEnum::Paid,
            OrderStatusEnum::Processing,
            OrderStatusEnum::Shipped,
        ]);
    }

    public function scopeIsCompleted(Builder $query)
    {
        return $query->where('status', OrderStatusEnum::Completed);
    }

    public function scopeIsArchived(Builder $query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeIsNotArchived(Builder $query)
    {
        return $query->where('is_archived', false);
    }

    /**
     * Начисление бонусов за покупку
     */
    public function earnBonuses(): void
    {
        $percentToBonus = $this->user->loyalty?->percent;
        if ($percentToBonus) {
            $this->bonuses()->create([
                'user_id' => $this->user_id,
                'amount' => ($this->total_price * $percentToBonus) / 100,
            ]);
        }
    }

    /**
     * Уменьшение остатка на складе (или увеличение по необходимости)
     */
    public function decrementProductStock(int $decrement = 1): void
    {
        $this->load('items.product', 'items.variation');

        $this->items->each(function (OrderItem $item) use ($decrement): void {
            if ($item->variation) {
                $item->variation->decrement(
                    'stock',
                    $item->quantity * $decrement,
                );
            } else {
                $item->product->decrement(
                    'stock',
                    $item->quantity * $decrement,
                );
            }
        });
    }

    /**
     * Убавление кол-ва доступных купонов
     */
    public function decrementCouponCount(int $decrement = 1): void
    {
        if ($this->coupon) {
            $this->coupon->decrement('count', $decrement);
        }
    }
}
