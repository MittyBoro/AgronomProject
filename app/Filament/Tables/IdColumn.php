<?php

namespace App\Filament\Tables;

use Filament\Tables\Columns\TextColumn;

class IdColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->label('ID')->grow(false)->width(1)->searchable()->sortable();
    }
}
