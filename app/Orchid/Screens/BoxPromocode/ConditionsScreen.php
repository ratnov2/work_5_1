<?php

namespace App\Orchid\Screens\BoxPromocode;

use App\Containers\BoxUnique\Tasks\GetPromocodableBoxTask;
use App\Orchid\Helpers\Condition\GetConditionParams;
use App\Orchid\Layouts\Conditions\ConditionsLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class ConditionsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Условия';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $box_promocode= app(GetPromocodableBoxTask::class)->run();

        return [
            'conditionable' => $box_promocode
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
            ConditionsLayout::class
        ];
    }

    public function update(Request $request)
    {
        $box_promocode= app(GetPromocodableBoxTask::class)->run();

        $condition_params = $request->get('condition');
        $condition_params = app(GetConditionParams::class)->run($condition_params);

        $box_promocode->condition
            ? $box_promocode->condition()->update($condition_params ?? [])
            : $box_promocode->condition()->create($condition_params ?? []);

        Alert::info('Успешное обновление');
        return redirect()->route('platform.box-promocode.conditions');
    }
}
