<?php

namespace App\Orchid\Screens\BoxLimit;

use App\Containers\BoxLimit\Models\BoxLimit;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class BoxesLimitScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Лимитированные кейсы';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'boxes_limit' => BoxLimit::filters()->defaultSort('id', 'desc')->paginate(10)
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
                ->route('platform.box-limit')
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
            Layout::table('boxes_limit', [
                TD::make('id', 'ID'),

                TD::make('name', 'Имя'),

                TD::make('position', 'Позиция')
                    ->sort(),

                TD::make('image', 'Изображение')
                    ->cantHide()
                    ->width(100)
                    ->render(function ($box_limit) {
                        return '<img style="width: 100%; filter: hue-rotate(' . ($box_limit->hue_rotate ?? 0) . 'deg);" src="' . $box_limit->image . '" alt="box" />';
                    }),

                TD::make('max_item_price', 'Макс. цена предмета (руб)'),

                TD::make('limit', 'Лимит')
                    ->render(function ($box_limit) {
                        return '<span style="color: red">' . $box_limit->limit_left . '</span>/<span style="color: black">' . $box_limit->limit . '</span>';
                    }),

                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function (BoxLimit $box_limit) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Редактировать'))
                                    ->icon('pencil')
                                    ->route('platform.box-limit', $box_limit->id),
                            ]);
                    }),
            ])
        ];
    }
}
