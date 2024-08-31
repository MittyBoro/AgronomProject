<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

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

    public function spentBonuses()
    {
        return $this->hasMany(Balance::class)->where('amount', '<', 0);
    }

    public function earnedBonuses()
    {
        return $this->hasMany(Balance::class)->where('amount', '>', 0);
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

    public function scopeIsArchived(Builder $query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeIsNotArchived(Builder $query)
    {
        return $query->where('is_archived', false);
    }
}
