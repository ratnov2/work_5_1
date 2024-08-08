<?php

namespace App\Orchid\Screens\BoxMoney;

use App\Containers\BoxMoney\Models\BoxMoney;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class BoxesMoneyScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Кейсы';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'boxes_money' => BoxMoney::orderBy('id', 'desc')->paginate(10)
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Создать')
                ->icon('pencil')
                ->route('platform.box-money')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::table('boxes_money', [
                TD::make('id', 'ID'),

                TD::make('image', 'Изображение')
                    ->cantHide()
                    ->width(100)
                    ->render(function ($box_money) {
                        return '<img src="' . $box_money->image . '" alt="box" />';
                    }),

                TD::make('name', 'Имя'),

                TD::make('price', 'Цена, РУБ'),

                TD::make('profit_precent', 'Профит, %'),

                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function ($box_money) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Редактировать'))
                                    ->icon('pencil')
                                    ->route('platform.box-money', $box_money->id),

                                Button::make(__('Удалить'))
                                    ->icon('trash')
                                    ->confirm('Удалить данный кейс?')
                                    ->method('remove', [
                                        'id' => $box_money->id,
                                    ]),
                            ]);
                    }),
            ])
        ];
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        $box_money = BoxMoney::findOrFail($request->get('id'));
        $box_money->delete();
        Toast::info('Кейс успешно удален');
    }
}
