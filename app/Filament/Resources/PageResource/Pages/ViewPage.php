<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Resources\Pages\ViewRecord as ViewRecordPage;

class ViewPage extends ViewRecordPage
{
    protected static string $resource = PageResource::class;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        redirect()->to($this->record->slug);
    }
}
