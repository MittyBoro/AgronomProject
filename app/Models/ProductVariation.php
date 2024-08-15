<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'variation_group_id',
        'title',
        'price_modifier',
        'stock',
        'order_column',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'stock' => 'integer',
            'price_modifier' => 'decimal:2',
        ];
    }

    /**
     * Get the product that owns the product variation.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variation that owns the product variation.
     */
    public function group()
    {
        return $this->belongsTo(
            VariationGroup::class,
            'variation_group_id',
            'id',
        );
    }
}
