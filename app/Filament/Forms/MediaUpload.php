<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MediaUpload extends SpatieMediaLibraryFileUpload
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->getUploadedFileNameForStorageUsing(
            fn(
                TemporaryUploadedFile $file,
                Model $record,
            ): string => (string) str(
                $file->getClientOriginalExtension(),
            )->prepend($record?->slug ?? $record?->id . '--image.'),
        )
            ->panelLayout('grid')
            ->reorderable()
            ->openable();
    }
}
