<?php

namespace App\Models;

use App\Models\Traits\HasMetaTitle;
use App\Models\Traits\HasResponsiveImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
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
    public static int $mediaMaxWidth = 1500;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'description',
        'content',

        'is_published',

        'meta_title',
        'meta_description',
        'meta_keywords',
        'order_column',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopeIsPublished($query): void
    {
        $query->where('is_published', true);
    }

    public function scopeSelectPublic($query, $full = false): void
    {
        $query
            ->select('id', 'slug', 'title', 'description', 'created_at')
            ->isPublished()
            ->when(
                $full,
                fn($q) => $q->addSelect([
                    'meta_title',
                    'meta_description',
                    'meta_keywords',
                    'content',
                ]),
                fn($q) => $q->latest(),
            )
            ->with('media');
    }
}
