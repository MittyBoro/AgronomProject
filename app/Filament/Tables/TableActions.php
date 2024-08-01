<?php

namespace App\Filament\Tables;

use Filament\Tables;

class TableActions
{
    public static function make(): array
    {
        return [
            Tables\Actions\ViewAction::make()
                ->iconButton()
                ->url('/')
                ->openUrlInNewTab('/'),
            Tables\Actions\EditAction::make()->button()->iconButton(false),
            Tables\Actions\DeleteAction::make()
                ->button()
                ->iconButton(false),
            Tables\Actions\ForceDeleteAction::make()->button()->iconButton(false),
            Tables\Actions\RestoreAction::make()->button()->iconButton(false),
        ];
    }
}
