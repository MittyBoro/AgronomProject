<?php

namespace App\Models;

use App\Enums\PropTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * !Помним про
 *
 * @see \Database\Seeders\PropSeeder
 * (приложение сверяется с данными оттуда)
 */
class Prop extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'key',
        'value',

        'group',
        'title',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => PropTypeEnum::class,
        ];
    }

    protected static function booted(): void
    {
        static::saved(function (self $prop): void {
            Cache::forget('props.' . $prop->key);
        });
        static::deleting(function (self $prop): void {
            Cache::forget('props.' . $prop->key);
        });
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (
                    in_array($this->type, [
                        PropTypeEnum::String,
                        PropTypeEnum::Number,
                        PropTypeEnum::Text,
                    ])
                ) {
                    return $value;
                }
                if ($this->type === PropTypeEnum::Media) {
                    return $this->media;
                }

                return $value;
            },
            set: function ($value) {
                $type = $this->attributes['type'] ?? null;

                if ($type === PropTypeEnum::Number->value) {
                    return (int) $value;
                }
                if ($type === PropTypeEnum::Media->value) {
                    return $this->media;
                }

                return $value;
            },
        );
    }

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever('props.' . $key, function () use (
            $key,
            $default,
        ) {
            return Prop::select('id', 'type', 'value')
                ->where('key', $key)
                ->first()?->value ?? $default;
        });
    }
}
