<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Filament\Traits\EditRecordPage;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    use EditRecordPage;

    protected static string $resource = PageResource::class;
}
