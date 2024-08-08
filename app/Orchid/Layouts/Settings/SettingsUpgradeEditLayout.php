<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class SettingsUpgradeEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'settings_upgrade';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): array
    {
        return [
            Input::make('settings_upgrade.profit_precent')
                ->type('number')
                ->step(0.01)
                ->title('Профит апгрейда, %'),
        ];
    }
}
