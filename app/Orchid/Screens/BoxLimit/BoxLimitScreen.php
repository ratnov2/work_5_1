<?php

namespace App\Orchid\Screens\BoxLimit;

use App\Containers\BoxLimit\Models\BoxLimit;
use App\Containers\Site\Models\Site;
use App\Orchid\Helpers\Condition\GetConditionParams;
use App\Orchid\Layouts\Conditions\ConditionsLayout;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\Picture;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Select;

class BoxLimitScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(BoxLimit $box_limit): array
    {
        $this->exists = $box_limit->exists;

        if($this->exists){
            $this->name = 'Редактирование';
        }

        return [
            'conditionable' => $box_limit,
            'box_limit' => $box_limit
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
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $boxes = BoxLimit::get();
        $positions = $boxes->pluck('position');
        $positions->push($boxes->count() + 1)->sortDesc();
        $options = [];
        foreach ($positions as $position)
            $options[$position] = $position;

        return [
            Layout::rows([
                Select::make('box_limit.position')
                    ->options($options)
                    ->empty('Не выбрано')
                    ->title('Позиция')
                    ->help('Позиция, на которой будет находиться кейс')
                    ->required(),

                Input::make('box_limit.name')
                    ->title('Отображемое имя (не обязательно)'),

                Picture::make('box_limit.image')
                    ->title('Отображемая картинка (не обязательно)'),

                Input::make('box_limit.max_item_price')
                    ->type('number')
                    ->step('0.01')
                    ->title('Макс. цена предмета')
                    ->required(),

                Input::make('box_limit.limit')
                    ->type('number')
                    ->title('Лимит')
                    ->required(),
            ]),

            ConditionsLayout::class,
        ];
    }

    public function createOrUpdate(BoxLimit $box_limit, Request $request)
    {
        $box_limit_params = $request->get('box_limit');
        $box_limit_params['limit_left'] = $box_limit->exists ? $box_limit->limit_left : $box_limit_params['limit'];

        if(is_null($box_limit_params['image'])) $box_limit_params['image'] = '/img/box_limit/default_v2.png';
        if(!$box_limit->exists) $box_limit_params['hue_rotate'] = rand(1, 360);
        if(is_null($box_limit_params['name'])) $box_limit_params['name'] = 'Лимитированный кейс';

        $condition_params = $request->get('condition');
        $condition_params = app(GetConditionParams::class)->run($condition_params);

        DB::transaction(function() use($box_limit, $box_limit_params, $condition_params) {
            if($box_limit->exists) {
                $box_limit->position < $box_limit_params['position']
                    ? BoxLimit::where([['position', '<=', $box_limit_params['position']], ['position', '>', $box_limit->position]])->decrement('position')
                    : BoxLimit::where([['position', '>=', $box_limit_params['position']], ['position', '<', $box_limit->position]])->increment('position');
            } else {
                BoxLimit::where('position', '>=', $box_limit_params['position'])->increment('position');
            }

            $box_limit->fill($box_limit_params);
            $box_limit->save();

            $box_limit->condition
                ? $box_limit->condition()->update($condition_params ?? [])
                : $box_limit->condition()->create($condition_params ?? []);
        });

        Alert::info('Успешно');
        return redirect()->route('platform.boxes-limit');
    }

    /**
     * @param Site $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(BoxLimit $box_limit)
    {
        DB::transaction(function() use($box_limit) {
            BoxLimit::where('position', '>', $box_limit->position)->decrement('position');
            $box_limit->delete();
        });

        Alert::info('Кейс успешно удален');
        return redirect()->route('platform.boxes-limit');
    }
}
