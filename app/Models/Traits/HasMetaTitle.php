<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasMetaTitle
{
    protected static function bootHasMetaTitle(): void
    {
        static::saving(function (Model $record): void {
            if ( ! $record->meta_title) {
                $record->meta_title = $record->title;
            }
        });
    }
}
