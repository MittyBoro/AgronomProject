<?php

namespace App\Filament\Resources\CallbackResource;

use App\Filament\Tables\ArchiveAction;
use App\Filament\Tables\IdColumn;
use App\Models\Callback;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class CallbackTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->heading('Заявки на обратную связь')
            ->columns([
                //
                IdColumn::make('id'),

                //
                TextColumn::make('name')
                    ->label('Автор')
                    ->description(
                        fn(Callback $record): HtmlString => new HtmlString(
                            implode(
                                '<br>',
                                array_filter([
                                    $record->email,
                                    $record->phone?->formatInternational(),
                                ]),
                            ),
                        ),
                    )
                    ->wrap()
                    ->searchable(),

                //
                TextColumn::make('message')
                    ->label('Текст')
                    ->wrap()
                    ->formatStateUsing(
                        fn(string $state): HtmlString => new HtmlString(
                            '<span class="  leading-tight line-clamp-4 max-w-60">' .
                                nl2br($state) .
                                '</span>',
                        ),
                    ),

                //
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->date('d.m.Y H:i')
                    ->dateTimeTooltip()
                    ->sortable(),
            ])
            ->filters([
                //
                SelectFilter::make('archive_status')
                    ->label('Список')
                    ->options([
                        'not_archived' => 'Основные',
                        'archived' => 'Архивированные',
                    ])
                    ->default('not_archived')
                    ->query(function (Builder $query, $state) {
                        if ($state['value'] === 'archived') {
                            return $query->where('is_archived', true);
                        }
                        if ($state['value'] === 'not_archived') {
                            return $query->where('is_archived', false);
                        }
                    }),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                //
                Tables\Actions\ViewAction::make()
                    ->modalHeading(
                        fn(Callback $record): string => 'Заявка #' .
                            $record->id,
                    )
                    ->button()
                    ->iconButton(false),
                ArchiveAction::make('archive')
                    ->button()
                    ->iconButton(false)
                    ->color(
                        fn(Callback $record): string => $record->is_archived
                            ? 'warning'
                            : 'info',
                    ),
                //
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->visible(fn(?Callback $record) => $record->is_archived)

                    ->iconButton(false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
