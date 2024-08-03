<?php

namespace App\Models;

use App\Models\Traits\HasResponsiveImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Review extends Model implements HasMedia
{
    use HasFactory, HasResponsiveImages, InteractsWithMedia {
        HasResponsiveImages::registerMediaConversions insteadof InteractsWithMedia;
    }

    public static int $mediaMaxWidth = 1000;

    protected $fillable = [
        'product_id',
        'user_id',
        'is_approved',
        'is_pinned',
        'rating',
        'name',
        'comment',
        'likes',
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
            'rating' => 'integer',
            'likes' => 'integer',
            'is_approved' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeIsApproved($query): void
    {
        $query->where('is_approved', true);
    }

    public function scopeIsPinned($query): void
    {
        $query->where('is_pinned', true);
    }

    public function scopeSelectPublic($query): void
    {
        $query
            ->select(
                'id',
                'product_id',
                'user_id',
                'is_approved',
                'is_pinned',
                'rating',
                'name',
                'comment',
                'likes',
            )
            ->isApproved()
            ->orderBy('order_column');
    }
}
