<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class SettingsJackpotEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'settings_jackpot';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): array
    {
        return [
            Input::make('settings_jackpot.profit_precent')
                ->type('number')
                ->step(0.01)
                ->title('Профит джекпота, %'),
        ];
    }
}
