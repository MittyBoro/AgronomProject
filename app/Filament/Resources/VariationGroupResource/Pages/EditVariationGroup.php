<?php

namespace App\Filament\Resources\VariationGroupResource\Pages;

use App\Filament\Resources\VariationGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVariationGroup extends EditRecord
{
    protected static string $resource = VariationGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
