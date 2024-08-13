<?php

namespace App\Models;

use App\Models\Traits\HasMetaTitle;
use App\Models\Traits\HasResponsiveImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory, HasMetaTitle, HasResponsiveImages, InteractsWithMedia {
        HasResponsiveImages::registerMediaConversions insteadof InteractsWithMedia;
    }

    /**
     * for responsive images HasResponsiveImages
     */
    public static int $mediaMaxWidth = 150;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
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
            'is_published' => 'boolean',
        ];
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeSelectPublic($query): void
    {
        $query
            ->addSelect('id', 'slug', 'title')
            ->with('media')
            ->orderBy('order_column', 'asc');
    }
}
