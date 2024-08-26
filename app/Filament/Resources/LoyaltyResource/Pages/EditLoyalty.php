<?php

namespace App\Filament\Resources\LoyaltyResource\Pages;

use App\Filament\Resources\LoyaltyResource;
use App\Filament\Traits\EditRecordPage;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoyalty extends EditRecord
{
    use EditRecordPage;

    protected static string $resource = LoyaltyResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
