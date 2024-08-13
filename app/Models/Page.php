<?php

namespace App\Models;

use App\Models\Traits\HasMetaTitle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use HasMetaTitle, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'blocks',
        'layout',
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
            'blocks' => 'array',
        ];
    }

    public function scopePublicSelect($query)
    {
        $query->select(
            'id',
            'slug',
            'title',
            'content',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'blocks',
        );
    }

    public function attrs(): Attribute
    {
        return Attribute::make(
            get: function () {
                $data = collect($this->blocks)
                    ->groupBy('type')
                    ->map->pluck('data.value')->toArray();
                return $data;
            },
        )->shouldCache();
    }
}
