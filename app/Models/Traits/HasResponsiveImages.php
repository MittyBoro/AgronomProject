<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasResponsiveImages
{
    private static int $mediaMaxWidthDefault = 1200;

    /**
     * Для регистрации дополнительных конверсий использовать
     * public function registerMediaConversions(Media $media = null) {}
     *
     * https://spatie.be/docs/laravel-medialibrary
     */
    abstract public function media(): MorphMany;

    public function registerMediaConversions(?Media $media = null): void
    {
        // Добавляем конверсию для формата JPEG
        $this->addMediaConversion('jpeg')
            ->fit(Fit::Max, $this->mediaMaxWidth ?? $this->mediaMaxWidthDefault)
            ->withResponsiveImages()
            ->format('jpg');

        // Добавляем конверсию для формата WebP
        $this->addMediaConversion('webp')
            ->fit(Fit::Max, $this->mediaMaxWidth ?? $this->mediaMaxWidthDefault)
            ->withResponsiveImages()
            ->format('webp');

        if (method_exists($this, 'registerCustomMediaConversions')) {
            $this->registerCustomMediaConversions($media);
        }
    }
}
