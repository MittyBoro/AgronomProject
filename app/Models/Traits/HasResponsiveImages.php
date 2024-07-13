<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasResponsiveImages
{
    /**
     * Для регистрации дополнительных конверсий использовать
     * public function registerMediaConversions(Media $media = null) {}
     *
     * https://spatie.be/docs/laravel-medialibrary
     */

    abstract public function media(): MorphMany;

    private int $responsiveMediaMaxWidth = 1200;

    public function registerMediaConversions(?Media $media = null): void
    {
        // Добавляем конверсию для формата JPEG
        $this->addMediaConversion('jpeg')
            ->fit(Fit::Max, $this->responsiveMediaMaxWidth)
            ->withResponsiveImages()
            ->format('jpg');

        // Добавляем конверсию для формата WebP
        $this->addMediaConversion('webp')
            ->fit(Fit::Max, $this->responsiveMediaMaxWidth)
            ->withResponsiveImages()
            ->format('webp');

        if (method_exists($this, 'registerCustomMediaConversions')) {
            $this->registerCustomMediaConversions($media);
        }
    }
}
