<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Traits\EditRecordPage;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    use EditRecordPage;

    protected static string $resource = ProductResource::class;
}
