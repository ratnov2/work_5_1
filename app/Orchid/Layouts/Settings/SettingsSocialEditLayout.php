<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class SettingsSocialEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'settings_social';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): array
    {
        return [
            Input::make('settings_social.VKONTAKTE_CLIENT_ID')
                ->type('number')
                ->step('1')
                ->title('VKONTAKTE CLIENT ID'),

            Input::make('settings_social.VKONTAKTE_CLIENT_SECRET')
                ->type('password')
                ->help('Защищённый ключ')
                ->title('VKONTAKTE CLIENT SECRET'),

            Input::make('settings_social.TELEGRAM_BOT_NAME')
                ->type('text')
                ->title('TELEGRAM BOT NAME'),
            
            Input::make('settings_social.TELEGRAM_TOKEN')
                ->type('password')
                ->title('TELEGRAM TOKEN'),
        ];
    }
}
