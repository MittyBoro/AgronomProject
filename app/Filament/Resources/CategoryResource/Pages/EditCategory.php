<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\Action::make('open')
            //     ->label('Открыть')
            //     ->url('/')
            //     ->shouldOpenUrlInNewTab(),
            Actions\Action::make('create_more')
                ->label('Создать ещё')
                ->color('gray')
                ->url(self::getResource()::getUrl('create')),
            Actions\DeleteAction::make(),
        ];
    }
}
