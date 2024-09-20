<?php

namespace App\Models;

use App\Contracts\OrderItemInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class OrderItem extends Model implements OrderItemInterface
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variation_id',
        'media_id',
        'product_title',
        'variation_title',
        'quantity',
        'price',
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
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variation that owns the order item.
     */
    public function variation()
    {
        return $this->belongsTo(
            ProductVariation::class,
            'product_variation_id',
        );
    }

    /**
     * Get the media that owns the order item.
     */
    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function getAmount()
    {
        return $this->price;
    }

    public function getName()
    {
        return trim($this->product_title . ' ' . $this->variation_title);
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
