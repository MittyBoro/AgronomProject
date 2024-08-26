<?php

namespace App\Models;

use App\Models\Traits\HasResponsiveImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements HasMedia
{
    use HasFactory, HasResponsiveImages, InteractsWithMedia {
        HasResponsiveImages::registerMediaConversions insteadof InteractsWithMedia;
    }

    /**
     * for responsive images HasResponsiveImages
     */
    public static int $mediaMaxWidth = 1500;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'url',
        'is_published',
        'expires_at',
        'order_column',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'expires_at' => 'datetime',
        ];
    }

    public function scopeIsPublished($query): void
    {
        $query->where('is_published', true)->where('expires_at', '>', now());
    }

    public function scopeSelectPublic($query): void
    {
        $query
            ->select('id', 'url')
            ->isPublished()
            ->with('media')
            ->orderBy('order_column', 'asc');
    }
}
