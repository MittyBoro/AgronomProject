<?php
namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Resources\Pages\ViewRecord as ViewRecordPage;

class ViewArticle extends ViewRecordPage
{
    protected static string $resource = ArticleResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        redirect()->to('articles/' . $this->record->slug);
    }
}
