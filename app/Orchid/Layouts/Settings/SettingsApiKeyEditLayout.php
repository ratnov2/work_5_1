<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class SettingsApiKeyEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'settings_api_key';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): array
    {
        return [
            Input::make('settings_api_key.MARKET_API_KEY')
                ->type('password')
                ->title('Market CS:GO Api Key'),

            Input::make('settings_api_key.STEAM_API_KEY')
                ->type('password')
                ->title('Steam Api Key'),
        ];
    }
}
