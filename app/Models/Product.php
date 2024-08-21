<?php

namespace App\Models;

use App\Models\Traits\HasMetaTitle;
use App\Models\Traits\HasResponsiveImages;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory,
        HasMetaTitle,
        HasResponsiveImages,
        InteractsWithMedia,
        SoftDeletes {
        HasResponsiveImages::registerMediaConversions insteadof InteractsWithMedia;
    }

    /**
     * for responsive images HasResponsiveImages
     */
    public static int $mediaMaxWidth = 1000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'description',

        'price',
        'discount',

        'stock',
        'is_published',

        'meta_title',
        'meta_description',
        'meta_keywords',
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
            'price' => 'integer',
            'total_price' => 'integer',
            'discount' => 'integer',
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
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the variations that belong to the product.
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class)
            ->with('group')
            ->orderBy('product_variations.order_column');
    }

    public function variationGroups()
    {
        return $this->belongsToMany(
            VariationGroup::class,
            'product_variations',
        )->orderBy('variation_groups.order_column');
    }

    protected function groupedVariations(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->variations
                ->groupBy('variation_group_id')
                ->map(
                    fn($list) => tap(
                        $list->first()->group,
                        fn($group) => ($group->variations = $list->toArray()),
                    ),
                )
                ->sortBy('order_column')
                ->toArray(),
        );
    }

    public function scopeIsPublished($query): void
    {
        $query->where('is_published', true);
    }

    public function scopeSelectPublic($query, $full = false): void
    {
        $query
            ->addSelect(
                'id',
                'slug',
                'title',
                'price',
                'discount',
                'stock',
                'is_published',
            )
            ->selectRaw('(price * (1 - discount / 100)) as total_price')
            ->when(
                $full,
                fn($q) => $q
                    ->addSelect([
                        'meta_title',
                        'meta_description',
                        'meta_keywords',
                        'description',
                    ])
                    ->with('variations', 'categories'),
                fn($q) => $q->withCount('variations'),
            )
            ->isPublished()
            ->with('media')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');
    }
}
