<?php

namespace App\Filament\Traits;

use Filament\Actions;

trait EditRecordPage
{
    public function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make('open')
                ->label('Открыть')
                ->url('/'),
            Actions\Action::make('create_more')
                ->label('Добавить ещё')
                ->color('gray')
                ->url(self::getResource()::getUrl('create')),
            Actions\DeleteAction::make(),
        ];
    }
}
