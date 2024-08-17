<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

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

    public function variations(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductVariation::class,
            'cart_item_product_variation',
        )->select('id', 'variation_group_id', 'price_modifier', 'title');
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: function () {
                $price = $this->product->price;

                foreach ($this->variations as $variation) {
                    $price += $variation->price_modifier;
                }

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
