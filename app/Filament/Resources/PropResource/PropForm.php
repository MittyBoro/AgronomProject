<?php

namespace App\Filament\Resources\PropResource;

use App\Enums\PropTypeEnum;
use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Models\Prop;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;

class PropForm extends BaseForm
{
    public static function make(Form $form): Form
    {
        return $form->columns(1)->schema([
            //
            Section::make('Параметры поля')
                ->schema([
                    TextInput::make('title')
                        ->label('Заголовок')
                        ->hint('Видно только в админке')
                        ->required()
                        ->maxLength(255),
                    //
                    TextInput::make('description')
                        ->label('Описание')
                        ->hint('Видно только в админке')
                        ->nullable()
                        ->maxLength(255),
                    //
                    TextInput::make('key')
                        ->label('Ключ')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->hint(
                            fn(?Prop $record): ?string => $record
                                ? 'Не рекомендуется менять'
                                : 'только латиница',
                        )
                        ->hintColor('danger')
                        ->maxLength(255),

                    Select::make('type')
                        ->label('Тип')
                        ->options(PropTypeEnum::array())
                        ->hint(
                            fn(?Prop $record): ?string => $record
                                ? 'Не рекомендуется менять'
                                : null,
                        )
                        ->hintColor('danger')
                        ->required(),
                ])
                ->footerActions([
                    Action::make('delete')
                        ->label('Удалить')
                        ->color('danger')
                        ->visible(fn(?Prop $record): bool => (bool) $record)
                        ->action(fn(Prop $record) => $record->delete())
                        ->requiresConfirmation()
                        ->icon('heroicon-o-trash')
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->body('Удалено')
                                ->send();
                        }),
                ])
                ->collapsible()
                ->collapsed(fn(?Prop $record): bool => (bool) $record),

            // value
            Section::make('')
                ->hidden(fn(?Prop $record): bool => !$record)
                ->schema([
                    // string, number
                    TextInput::make('value')
                        ->label('Значение')
                        ->numeric(
                            fn(Get $get): bool => $get('type') === 'number',
                        )
                        ->visible(
                            fn(Prop $record): bool => in_array($record->type, [
                                PropTypeEnum::String,
                                PropTypeEnum::Number,
                            ]),
                        )
                        ->nullable(),

                    // text
                    Textarea::make('value')
                        ->label('Значение')
                        ->rows(5)
                        ->autosize()
                        ->visible(
                            fn(Prop $record): bool => $record->type ===
                                PropTypeEnum::Text,
                        )
                        ->nullable(),

                    // media
                    MediaUpload::make('media')
                        ->visible(
                            fn(Prop $record): bool => $record->type ===
                                PropTypeEnum::Media,
                        )
                        ->label('Файлы')
                        ->multiple(),
                ]),
        ]);
    }
}
