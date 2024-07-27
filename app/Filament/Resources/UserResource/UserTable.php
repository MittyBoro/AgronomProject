<?php

namespace App\Filament\Resources\UserResource;

use App\Enums\RoleEnum;
use App\Filament\Tables\IdColumn;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TableUser
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns(self::columns())
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->persistSortInSession()
            ->defaultSort('id', 'desc');
    }

    private static function columns(): array
    {
        return [
            //
            IdColumn::make('id'),
            //
            TextColumn::make('name')
                ->label('Имя')
                ->searchable()
                ->sortable()
                ->description(
                    fn (User $user): string => implode(
                        ' ',
                        array_filter([
                            $user->last_name,
                            $user->first_name,
                            $user->middle_name,
                        ]),
                    ),
                    position: 'below',
                )
                ->wrap(),
            //
            TextColumn::make('email')
                ->label('E-mail')
                ->icon(
                    fn (User $user): ?string => ! $user->email_verified_at
                        ? 'heroicon-m-exclamation-triangle'
                        : null,
                )
                ->tooltip(
                    fn (TextColumn $column): ?string => ! $column->getRecord()
                        ->email_verified_at
                        ? 'E-mail не подтверждён'
                        : null,
                )

                ->iconPosition(IconPosition::After)
                ->iconColor('warning')
                ->searchable()
                ->sortable()
                ->copyable()
                ->copyMessage('Email скопирован в буфер обмена'),
            //
            TextColumn::make('role')
                ->label('Роль')
                ->badge()
                ->color(
                    fn (RoleEnum $state): string => match ($state) {
                        RoleEnum::Admin => 'danger',
                        default => 'info',
                    },
                )
                ->formatStateUsing(
                    fn (RoleEnum $state): string => $state->label(),
                )
                ->searchable()
                ->sortable(),
            //
            TextColumn::make('created_at')
                ->label('Регистрация')
                ->dateTime('d.m.Y H:i')
                ->sortable(),
        ];
    }
}
