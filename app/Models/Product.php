<?php

namespace App\Models;

use App\Models\Traits\HasResponsiveImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, HasResponsiveImages, InteractsWithMedia {
        HasResponsiveImages::registerMediaConversions insteadof InteractsWithMedia;
    }

    /**
     * for responsive images HasResponsiveImages
     * @var int
     */
    public static int $mediaMaxWidth = 1000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'description',

        'price',
        'stock',
        'is_published',

        'meta_title',
        'meta_description',
        'meta_keywords',
        'position',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'price' => 'decimal:0',
            'stock' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Get the categories that belong to the product.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the variations that belong to the product.
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
