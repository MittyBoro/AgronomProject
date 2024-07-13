<?php

namespace App\Models;

use App\Enums\VariationTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['type', 'name', 'position'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => VariationTypeEnum::class,
        ];
    }

    /**
     * Get the product variations for the variation.
     */
    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
