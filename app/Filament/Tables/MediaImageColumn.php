<?php

namespace App\Filament\Tables;

use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Model;

class MediaImageColumn extends SpatieMediaLibraryImageColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
            ->defaultImageUrl(asset('assets/images/placeholder.svg'))
            ->width(30)
            ->height(30)
            ->limit(1)
            ->circular()
            ->limitedRemainingText()
            ->stacked()
            ->tooltip(fn(Model $record): string => 'ID: ' . $record->id)
            ->grow(false);
    }
}
