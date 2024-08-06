<?php
namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\ViewRecord as ViewRecordPage;

class ViewCategory extends ViewRecordPage
{
    protected static string $resource = CategoryResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        redirect()->to('catalog/' . $this->record->slug);
    }
}
