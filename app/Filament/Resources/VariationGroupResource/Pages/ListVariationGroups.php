<?php

namespace App\Filament\Resources\VariationGroupResource\Pages;

use App\Filament\Resources\VariationGroupResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListVariationGroups extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = VariationGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
