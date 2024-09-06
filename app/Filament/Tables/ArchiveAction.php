<?php

namespace App\Filament\Tables;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ArchiveAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-m-archive-box')
            ->label(
                fn(Model $record): string => $record->is_archived
                    ? 'Восстановить'
                    : 'Архивировать',
            )
            ->color(
                fn(Model $record): string => $record->is_archived
                    ? 'warning'
                    : 'gray',
            )
            ->action(function (Model $record): void {
                $record->update([
                    'is_archived' => !$record->is_archived,
                ]);
            })
            ->after(function (Model $record): void {
                Notification::make()
                    ->success()
                    ->title('#' . $record->id)
                    ->body(
                        $record->is_archived ? 'Архивировано' : 'Восстановлено',
                    )
                    ->send();
            });
    }
}
