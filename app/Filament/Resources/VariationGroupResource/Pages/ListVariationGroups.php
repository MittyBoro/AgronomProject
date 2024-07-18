<?php

namespace App\Filament\Resources\VariationGroupResource\Pages;

use App\Filament\Resources\VariationGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVariationGroups extends ListRecords
{
    protected static string $resource = VariationGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
