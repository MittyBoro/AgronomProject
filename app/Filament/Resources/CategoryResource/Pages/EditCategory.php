<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Filament\Traits\EditRecordPage;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    use EditRecordPage;

    protected static string $resource = CategoryResource::class;
}
