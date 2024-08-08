<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class SettingsPaymentSystemEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'settings_payment_system';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): array
    {
        return [
            Input::make('settings_payment_system.ENOT_MERCHANT_ID')
                ->type('number')
                ->step('1')
                ->title('Enot Merchant ID'),

            Input::make('settings_payment_system.ENOT_SECRET_WORD')
                ->type('password')
                ->title('Enot secret word'),

            Input::make('settings_payment_system.ENOT_EXTRA_SECRET_WORD')
                ->type('password')
                ->title('Enot secret word 2'),
        ];
    }
}
