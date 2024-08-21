<?php

namespace App\Models;

use App\Enums\CartTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_variation_id',
        'quantity',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->select(
            'id',
            'slug',
            'title',
            'price',
            'discount',
            'stock',
            'is_published',
        );
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(
            ProductVariation::class,
            'product_variation_id',
        )->select(
            'id',
            'product_id',
            'variation_group_id',
            'price_modifier',
            'title',
            'stock',
        );
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: function () {
                $price =
                    $this->product->price + $this->variation?->price_modifier;
                return $price;
            },
        )->shouldCache();
    }

    public function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => ($this->price *= 1 - $this->product->discount / 100),
        )->shouldCache();
    }
}
