<?php

namespace App\Orchid\Screens\BoxPromocode;

use App\Containers\BoxUnique\Models\BoxPromocode;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

class PromocodesScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список промокодов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'box_promocodes' => BoxPromocode::filters()->defaultSort('id', 'desc')->paginate(30)
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
            Link::make(__('Скачать активные промокоды'))
                ->route('platform.file.download.box-promocodes'),

            Link::make('Создать пачку промокодов')
                ->icon('pencil')
                ->route('platform.box-promocode.promocodes.pack'),

            Link::make('Создать')
                ->icon('pencil')
                ->route('platform.box-promocode.promocode'),
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
            Layout::table('box_promocodes', [
                TD::make('id', 'ID')
                    ->sort(),

                TD::make('value', 'Промокод')
                    ->filter(TD::FILTER_TEXT),

                TD::make('limit', 'Лимит')
                    ->filter(TD::FILTER_TEXT)
                    ->render(function(BoxPromocode $box_promocode) {
                        if(is_null($box_promocode->limit)) return 'Безлимитный';
                        return 'Осталось ' . $box_promocode->limit . ' активаций';
                    }),

                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function (BoxPromocode $box_promocode) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Редактировать'))
                                    ->icon('pencil')
                                    ->route('platform.box-promocode.promocode', $box_promocode->id),

                                Button::make(__('Удалить'))
                                    ->icon('trash')
                                    ->confirm('Удалить этот промокод?')
                                    ->method('remove', [
                                        'id' => $box_promocode->id,
                                    ]),
                            ]);
                    }),
            ])
        ];
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request)
    {
        BoxPromocode::findOrFail($request->get('id'))
            ->delete();

        Toast::info('Промокод для кейса удален');

        return redirect()->route('platform.box-promocode.promocodes');
    }
}
