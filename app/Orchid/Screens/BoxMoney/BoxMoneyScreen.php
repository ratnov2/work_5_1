<?php

namespace App\Orchid\Screens\BoxMoney;

use App\Containers\BoxMoney\Models\BoxMoney;
use App\Containers\BoxMoney\Models\BoxMoneyCategory;
use App\Containers\Site\Models\Site;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\Picture;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;

class BoxMoneyScreen extends Screen
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
    public function query(BoxMoney $box_money): array
    {
        $this->exists = $box_money->exists;

        if($this->exists){
            $this->name = 'Редактирование';
        }

        return [
            'box_money' => $box_money
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
        return [
            Layout::rows([

                Input::make('box_money.name')
                    ->title('Отображемое имя')
                    ->required(),

                Picture::make('box_money.image')
                    ->title('Отображемая картинка')
                    ->required(),

                Input::make('box_money.price')
                    ->type('number')
                    ->step('0.01')
                    ->title('Цена')
                    ->required(),

                Input::make('box_money.profit_precent')
                    ->type('number')
                    ->step('0.01')
                    ->title('Профит, %')
                    ->required(),

                Relation::make('box_money.category_id')
                    ->fromModel(BoxMoneyCategory::class, 'id')
                    ->displayAppend('name')
                    ->title('Категория')
                    ->required(),
            ]),
        ];
    }

    public function create(BoxMoney $box_money, Request $request)
    {
        $box_money_params = $request->get('box_money');
        $box_money->fill($box_money_params);
        $box_money->save();

        Alert::info('Успешное создание кейса');
        return redirect()->route('platform.boxes-money');
    }

    public function update(BoxMoney $box_money, Request $request)
    {
        $box_money_params = $request->get('box_money');
        $box_money->fill($box_money_params);
        $box_money->save();

        Alert::info('Успешное обновление лимитированного кейса');
        return redirect()->route('platform.boxes-money');
    }

    /**
     * @param Site $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(BoxMoney $box_money)
    {
        $box_money->delete();

        Alert::info('Кейс успешно удален');
        return redirect()->route('platform.boxes-money');
    }
}
