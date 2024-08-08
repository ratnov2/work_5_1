<?php

namespace App\Orchid\Screens\BoxPromocode;

use App\Containers\Settings\Tasks\GetSettingsBoxTask;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SettingsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Настройки';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $settings_box = app(GetSettingsBoxTask::class)->run();

        return [
            'settings_box' => $settings_box
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Обновить')
                ->icon('note')
                ->method('update'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                CheckBox::make('settings_box.box_promocode')
                    ->sendTrueOrFalse()
                    ->title('Кейс по промокоду'),

                Input::make('settings_box.box_promocode_max_item_price')
                    ->type('number')
                    ->step(0.01)
                    ->title('Кейс по промокоду, макс. цена предмета'),
            ]),
        ];
    }

    public function update(Request $request)
    {
        $settings_box = app(GetSettingsBoxTask::class)->run();
        $settings_box->fill($request->get('settings_box'));
        $settings_box->save();

        Alert::info('Успешно обновлено');

        return redirect()->route('platform.box-timer.settings');
    }
}
