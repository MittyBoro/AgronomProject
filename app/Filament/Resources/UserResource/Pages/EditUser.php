<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Traits\EditRecordPage;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    use EditRecordPage;

    protected static string $resource = UserResource::class;
}
