<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\ViewRecord as ViewRecordPage;

class ViewProduct extends ViewRecordPage
{
    protected static string $resource = ProductResource::class;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        redirect()->to('products/' . $this->record->slug);
    }
}
