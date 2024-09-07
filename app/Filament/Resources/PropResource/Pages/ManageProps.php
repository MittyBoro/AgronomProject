<?php

namespace App\Filament\Resources\PropResource\Pages;

use App\Filament\Resources\PropResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProps extends ManageRecords
{
    protected static string $resource = PropResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
