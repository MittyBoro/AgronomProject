<?php

namespace App\Filament\Resources\LoyaltyResource\Pages;

use App\Filament\Resources\LoyaltyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoyalties extends ListRecords
{
    protected static string $resource = LoyaltyResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
