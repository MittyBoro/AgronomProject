<?php

namespace App\Models;

use App\Enums\VariationGroupTypeEnum;
use Illuminate\Database\Eloquent\Model;

class VariationGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['type', 'title', 'order_column'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => VariationGroupTypeEnum::class,
        ];
    }

    /**
     * Get the product variations for the variation.
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
