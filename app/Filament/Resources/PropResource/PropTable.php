<?php

namespace App\Filament\Resources\PropResource;

use App\Enums\PropTypeEnum;
use App\Filament\Tables\TableActions;
use App\Models\Prop;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class PropTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('title')
                    ->description(fn(Prop $record) => $record->description)
                    ->label('Название')
                    ->searchable(),
                //
                TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->copyable(),
                //
                TextColumn::make('value')
                    ->label('Значение')
                    ->wrap()
                    ->formatStateUsing(function (Prop $record, $state) {
                        if ($record->type === PropTypeEnum::Media) {
                            return 'Файлы: ' . $record->media()->count();
                        }

                        return new HtmlString(
                            '<span class="leading-tight line-clamp-3 max-w-60">' .
                                nl2br($state) .
                                '</span>',
                        );
                    }),
            ])
            //
            ->defaultGroup(
                Group::make('group')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible()
                    ->orderQueryUsing(
                        fn(
                            Builder $query,
                            string $direction,
                        ) => $query->orderBy('order_column', $direction),
                    ),
            )
            //
            ->actions(TableActions::make(view: false, delete: false))
            //
            ->defaultSort('order_column')
            ->reorderable('order_column');
    }
}
