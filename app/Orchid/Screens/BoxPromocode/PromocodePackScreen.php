<?php

namespace App\Orchid\Screens\BoxPromocode;

use App\Containers\BoxUnique\Models\BoxPromocode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PromocodePackScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание пачки промокодов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [

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
            Button::make('Создать')
                ->icon('check')
                ->method('create')
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
                Input::make('box_promocodes.count')
                    ->type('number')
                    ->required()
                    ->title('Кол-во промокодов'),

                Input::make('box_promocodes.limit')
                    ->required()
                    ->type('number')
                    ->title('Кол-во активаций')
                    ->help('Значение 0 - бесконечный'),
            ])
        ];
    }

    public function create(Request $request)
    {
        $params = $request->get('box_promocodes');
        if($params['limit'] == 0) $params['limit'] = null;

        $box_promocodes = [];
        for ($i = 0; $i < $params['count']; $i++) {
            $box_promocodes[] = [
                'value' => strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)),
                'limit' => $params['limit']
            ];
        }

        BoxPromocode::insert($box_promocodes);

        Alert::info('Пачка промокодов создана');

        return redirect()->route('platform.box-promocode.promocodes');
    }
}
