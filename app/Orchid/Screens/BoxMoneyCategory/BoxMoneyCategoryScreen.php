<?php

namespace App\Orchid\Screens\BoxMoneyCategory;

use App\Containers\BoxMoney\Models\BoxMoneyCategory;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class BoxMoneyCategoryScreen extends Screen
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
    public function query(BoxMoneyCategory $box_money_category): array
    {
        $this->exists = $box_money_category->exists;

        if($this->exists){
            $this->name = 'Редактирование';
        }

        return [
            'box_money_category' => $box_money_category
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
                ->method('create')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('update')
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
        $positions = BoxMoneyCategory::pluck('position');
        if(!$this->exists) $positions->push($positions->count() + 1);
        $positions->sortDesc();

        $options = [];
        foreach ($positions as $position)
            $options[$position] = $position;

        return [
            Layout::rows([

                Input::make('box_money_category.name')
                    ->title('Имя')
                    ->required(),

                Select::make('box_money_category.position')
                    ->options($options)
                    ->empty('Не выбрано')
                    ->title('Позиция')
                    ->required(),
            ]),
        ];
    }

    public function create(BoxMoneyCategory $box_money_category, Request $request)
    {
        DB::transaction(function () use($box_money_category, $request) {
            $box_money_category_params = $request->get('box_money_category');

            BoxMoneyCategory::where('position', '>=', $box_money_category_params['position'])->orderBy('position', 'desc')->increment('position');

            $box_money_category->fill($box_money_category_params);
            $box_money_category->save();
        });

        Alert::info('Успешное создание категории');
        return redirect()->route('platform.box-money-categories');
    }

    public function update(BoxMoneyCategory $box_money_category, Request $request)
    {
        DB::transaction(function () use($box_money_category, $request) {
            $box_money_category_params = $request->get('box_money_category');

            $box_money_category->position < $box_money_category_params['position']
                ? BoxMoneyCategory::where([['position', '<=', $box_money_category_params['position']], ['position', '>', $box_money_category->position]])->decrement('position')
                : BoxMoneyCategory::where([['position', '>=', $box_money_category_params['position']], ['position', '<', $box_money_category->position]])->increment('position');

            $box_money_category->fill($box_money_category_params);
            $box_money_category->save();
        });

        Alert::info('Успешное обновление категории');
        return redirect()->route('platform.box-money-categories');
    }

    /**
     * @param Site $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(BoxMoneyCategory $box_money_category)
    {
        DB::transaction(function() use($box_money_category) {
            $box_money_category->delete();
            BoxMoneyCategory::where('position', '>', $box_money_category->position)->decrement('position');
        });

        Alert::info('Категория успешно удалена');
        return redirect()->route('platform.box-money-categories');
    }
}
