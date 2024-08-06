<?php

namespace App\Filament\Resources\ProductResource;

use App\Models\VariationGroup;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductFormTabPrice
{
    /**
     * Базовая цена
     * Остаток на складе (если нет вариаций)
     *
     * Редактор групп вариаций (редактировать по экшену)
     * галочки для групп для товара
     *
     * группы выбранных вариаций
     * вариации
     *  имя (скрываемо)
     *  кол-во
     *  цена
     */
    private static Collection $groups;

    public static function schema(): array
    {
        static::$groups = VariationGroup::orderBy('order_column')->get();

        return [
            // базовая цена
            TextInput::make('price')
                ->default(0)
                ->label('Базовая цена')
                ->live()
                ->prefix('₽')
                ->minValue(0)
                ->maxValue(42949672)
                ->numeric()
                ->mask(RawJs::make('$money($input, `.`, ` `)'))
                ->stripCharacters([' '])
                ->hint(
                    fn(Get $get): ?string => !$get('price')
                        ? 'Цена не установлена!'
                        : '',
                )
                ->hintColor('danger'),

            TextInput::make('discount')
                ->default(0)
                ->label('Скидка')
                ->live()
                ->prefix('%')
                ->minValue(0)
                ->maxValue(100)
                ->numeric()
                ->hint(fn(Get $get): ?string => self::discountHint($get))
                ->hintColor('primary'),
            // остаток
            TextInput::make('stock')
                ->default(0)
                ->label('Остаток на складе')
                ->suffix(' шт.')
                ->minValue(0)
                ->maxValue(9999999)
                ->hidden(fn(Get $get): bool => !empty($get('enabled_groups')))
                ->integer()
                ->live()
                ->hint(
                    fn(Get $get): ?string => $get('stock') < 10
                        ? (!$get('stock')
                            ? 'Закончился'
                            : 'Заканчивается')
                        : '',
                )
                ->hintColor('warning'),

            // редактор групп вариаций
            Section::make('Вариации')
                ->compact()
                ->headerActions([static::variationGroupsAction()])
                ->schema([
                    //
                    CheckboxList::make('enabled_groups')
                        ->relationship(
                            'variationGroups',
                            titleAttribute: 'title',
                        )
                        ->label('')
                        ->reactive()
                        ->columns(3),
                ])
                ->label('Вариации'),

            // выбранные группы вариаций
            Grid::make('Вариации продукта')
                ->schema(
                    fn(Get $get) => static::variationGroupFieldsets(
                        $get('enabled_groups'),
                    ),
                )
                ->columns(1)
                ->reactive(),
        ];
    }

    /**
     *  выбранная группа
     */
    protected static function variationGroupFieldsets($selectedGroups): array
    {
        $variationGroups = static::$groups->whereIn('id', $selectedGroups);

        return $variationGroups
            ->map(function ($group) {
                return Fieldset::make($group->title)
                    ->schema([static::variationsRepeater($group)])
                    ->columns(1);
            })
            ->toArray();
    }

    /***
     * Вариации в группе
     */

    private static function variationsRepeater($group): Repeater
    {
        return Repeater::make("variations_{$group->id}")
            ->label('')
            ->relationship(
                'variations',
                fn(Builder $query) => $query->where(
                    'variation_group_id',
                    $group->id,
                ),
            )
            ->addActionLabel('Добавить вариацию')
            ->columns(2)
            ->orderColumn('order_column')
            ->itemLabel(fn(array $state): ?string => $state['title'] ?? null)
            ->collapsible()
            ->cloneable()

            // скрыть кнопки
            ->collapseAllAction(fn(Action $action) => $action->hidden())
            ->expandAllAction(fn(Action $action) => $action->hidden())

            // элемент вариации
            ->schema(static::variationsItem($group))
            ->extraAttributes([
                'class' => 'variation-repeater',
            ])
            ->deleteAction(fn(Action $action) => $action->color('gray'))
            ->extraItemActions([
                //
                Action::make('Редактировать')
                    ->icon('heroicon-m-pencil-square')
                    ->action(function (
                        array $arguments,
                        Repeater $component,
                    ): void {
                        $state = $component->getState();
                        $state[$arguments['item']]['is_editing'] = !(
                            $state[$arguments['item']]['is_editing'] ?? false
                        );
                        $component->state($state);
                    }),
            ]);
    }

    /**
     * элемент вариации
     */
    private static function variationsItem($group): array
    {
        return [
            Hidden::make('variation_group_id')->default($group->id),
            //
            TextInput::make('title')
                ->label('Название')
                ->required()
                ->live()
                ->columnSpan(2)
                ->hidden(
                    fn(Get $get, ?Model $record): bool => !$get('is_editing') &&
                        $record?->id,
                ),
            //
            TextInput::make('price_modifier')
                ->default(0)
                ->required()
                ->label('Модификатор цены')
                ->prefix('₽')
                ->numeric()
                ->mask(RawJs::make('$money($input, `.`, ` `)'))
                ->stripCharacters([' '])
                ->live()
                ->hint(
                    fn(Get $get): ?string => 'Итог: ' .
                        price_formatter(static::variationPrice($get)) .
                        '₽',
                )
                ->hintColor(
                    fn(Get $get): ?string => static::variationPrice($get) <= 0
                        ? 'danger'
                        : null,
                ),
            //
            TextInput::make('stock')
                ->default(0)
                ->label('Остаток на складе')
                ->suffix(' шт.')
                ->minValue(0)
                ->maxValue(9999999)
                ->integer()
                ->live()
                ->required()
                ->hintIcon(
                    fn(Get $get): ?string => $get('stock') < 10
                        ? (!$get('stock')
                            ? 'heroicon-m-exclamation-triangle'
                            : 'heroicon-o-exclamation-triangle')
                        : '',
                )
                ->hintColor(
                    fn(Get $get): ?string => !$get('stock')
                        ? 'danger'
                        : 'warning',
                ),
        ];
    }

    /**
     * итоговая цена продукта с модификатором
     */
    private static function variationPrice(Get $get): int
    {
        return parse_price($get('../../price')) +
            parse_price($get('price_modifier'));
    }

    /**
     * подсказка для скидки с итоговой ценой
     */
    private static function discountHint(Get $get): string
    {
        $price = parse_price($get('price'));
        return $get('discount')
            ? 'Цена с учётом скидки: ' .
                    price_formatter(
                        $price - ($price * $get('discount')) / 100,
                    ) .
                    ' ₽'
            : '';
    }

    /**
     * ****
     * ****
     * ****
     * редактор групп вариаций в модальном окне
     */
    private static function variationGroupsAction(): Action
    {
        return Action::make('variation_groups_edit')
            ->label('Редактировать')
            ->color('gray')
            ->iconButton(false)
            ->size('xs')
            ->button()
            ->mountUsing(
                fn(Form $form) => $form->fill([
                    'main_variation_groups' => static::$groups,
                ]),
            )
            ->form([
                //
                Repeater::make('main_variation_groups')
                    ->hiddenLabel()
                    ->addActionLabel('Добавить группу вариаций')
                    ->schema([
                        //
                        TextInput::make('title')
                            ->hiddenLabel()
                            ->required()
                            ->placeholder('Название группы')
                            ->markAsRequired(false)
                            ->live(),
                    ])
                    ->deleteAction(
                        fn(Action $action) => $action
                            ->requiresConfirmation()
                            ->modalHeading('Удалить группу вариаций?')
                            ->modalDescription(
                                'Удаление группы приведёт к удалению ВСЕХ вариаций этой группы во ВСЕХ товарах!',
                            )
                            ->modalSubmitActionLabel(
                                'Удалить группу и всё, что с ней связано',
                            ),
                    )
                    ->itemLabel(
                        fn(array $state): ?string => '#' .
                            ($state['id'] ?? null) .
                            ' ' .
                            ($state['title'] ?? null),
                    ),
            ])
            ->action(function (array $data): void {
                // удаление первым, ибо у новых нет id и их после создания снесёт
                // Удаляем группы, которых нет в новом списке
                $keepIds = collect($data['main_variation_groups'])
                    ->pluck('id')
                    ->filter()
                    ->values();
                VariationGroup::whereNotIn('id', $keepIds)->delete();

                // Обновляем группы
                foreach ($data['main_variation_groups'] as $key => $groupData) {
                    if (isset($groupData['id'])) {
                        VariationGroup::find($groupData['id'])->update([
                            'title' => $groupData['title'],
                            'order_column' => $key,
                        ]);
                    } else {
                        VariationGroup::create([
                            'title' => $groupData['title'],
                            'order_column' => $key,
                        ]);
                    }
                }
            })
            ->modalHeading('Редактировать группы вариаций');
    }
}
