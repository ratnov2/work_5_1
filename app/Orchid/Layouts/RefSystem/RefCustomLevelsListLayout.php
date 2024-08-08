<?php

namespace App\Orchid\Layouts\RefSystem;

use App\Containers\RefSystem\Models\RefLevel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class RefCustomLevelsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'ref_custom_levels';

    protected $title = 'Кастомные уровни';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('bonus_precent', 'Бонус за каждого реферала')
                ->render(function(RefLevel $ref_level) {
                    return $ref_level->bonus_precent . " %";
                }),
            TD::make('bonus_precent', 'Реф. бонус')
                ->render(function(RefLevel $ref_level) {
                    return $ref_level->ref_bonus_precent . " %";
                }),
            TD::make('name', 'Имя уровня'),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (RefLevel $ref_level) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Редактировать'))
                                ->icon('pencil')
                                ->route('platform.ref-custom-level.edit', $ref_level->id),

                            Button::make(__('Удалить'))
                                ->icon('trash')
                                ->confirm('Удалить этот уровень?')
                                ->method('remove', [
                                    'id' => $ref_level->id,
                                ]),
                        ]);
                }),
        ];
    }
}
