<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

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
