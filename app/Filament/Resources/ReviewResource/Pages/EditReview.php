<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use App\Filament\Traits\EditRecordPage;
use Filament\Resources\Pages\EditRecord;

class EditReview extends EditRecord
{
    use EditRecordPage;

    protected static string $resource = ReviewResource::class;
}
