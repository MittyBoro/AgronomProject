<?php

namespace App\Filament\Tables;

use Filament\Tables;

class TableActions
{
    public static function make(
        bool $view = true,
        bool $edit = true,
        bool $delete = true,
        bool $forceDelete = true,
        bool $restore = true,
    ): array {
        $actions = [];

        if ($view) {
            $actions[] = Tables\Actions\ViewAction::make()
                ->button()
                ->iconButton(false)
                ->openUrlInNewTab();
        }

        if ($edit) {
            $actions[] = Tables\Actions\EditAction::make()
                ->button()
                ->iconButton(false);
        }

        if ($delete) {
            $actions[] = Tables\Actions\DeleteAction::make()
                ->button()
                ->iconButton(false);
        }

        if ($forceDelete) {
            $actions[] = Tables\Actions\ForceDeleteAction::make()
                ->button()
                ->iconButton(false);
        }

        if ($restore) {
            $actions[] = Tables\Actions\RestoreAction::make()
                ->button()
                ->iconButton(false);
        }

        return $actions;
    }
}
