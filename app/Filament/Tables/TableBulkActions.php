<?php

namespace App\Filament\Tables;

use Filament\Tables;

class TableBulkActions
{
    public static function make(): array
    {
        return [
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\ForceDeleteBulkAction::make(),
            Tables\Actions\RestoreBulkAction::make(),
            // ...
        ];
    }
}
