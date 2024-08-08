<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class SettingsTopContestEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'settings_top_contest';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): array
    {
        return [
            Input::make('settings_top_contest.every_hours')
                ->type('number')
                ->step(1)
                ->title('Частота топа, часы')
                ->required(),

            Input::make('settings_top_contest.first_place_sum')
                ->type('number')
                ->step(0.01)
                ->title('Награда за первое место')
                ->required(),

            Input::make('settings_top_contest.second_place_sum')
                ->type('number')
                ->step(0.01)
                ->title('Награда за второе место')
                ->required(),

            Input::make('settings_top_contest.third_place_sum')
                ->type('number')
                ->step(0.01)
                ->title('Награда за третье место')
                ->required()
        ];
    }
}
