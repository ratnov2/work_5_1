<?php

namespace App\Orchid\Screens\BoxMoneyCategory;

use App\Containers\BoxMoney\Models\BoxMoneyCategory;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class BoxMoneyCategoriesScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Категории кейсов';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'boxes_money_categories' => BoxMoneyCategory::orderBy('position')->paginate(10)
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
                ->route('platform.box-money-category')
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
            Layout::table('boxes_money_categories', [
                TD::make('id', 'ID'),

                TD::make('name', 'Имя'),

                TD::make('position', 'Позиция'),

                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function ($box_money_category) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Редактировать'))
                                    ->icon('pencil')
                                    ->route('platform.box-money-category', $box_money_category->id),

                                Button::make(__('Удалить'))
                                    ->icon('trash')
                                    ->confirm('Удалить?')
                                    ->method('remove', [
                                        'id' => $box_money_category->id,
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
        DB::transaction(function() use($request) {
            $box_money_category = BoxMoneyCategory::findOrFail($request->get('id'));
            $box_money_category->delete();

            BoxMoneyCategory::where('position', '>', $box_money_category->position)->decrement('position');
        });

        Toast::info('Категория успешно удалена');
    }
}
