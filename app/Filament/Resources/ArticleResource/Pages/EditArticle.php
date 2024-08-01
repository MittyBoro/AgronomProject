<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Filament\Traits\EditRecordPage;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    use EditRecordPage;

    protected static string $resource = ArticleResource::class;
}
