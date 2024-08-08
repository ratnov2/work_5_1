<?php

namespace App\Orchid\Screens\Site;

use App\Containers\Site\Models\Site;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\DB;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class SiteListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Сайты';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все Сайты';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'sites' => Site::paginate(10)
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
            Link::make('Создать сайт')
                ->icon('pencil')
                ->route('platform.site.edit')
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
            Layout::table('sites', [
                TD::make('id', 'ID'),
                TD::make('position', 'Позиция'),
                TD::make('image', __('Image'))
                    ->cantHide()
                    ->width(100)
                    ->render(function (Site $site) {
                        return '<img style="width: 100%" src="' . $site->image . '" alt="box" />';
                    }),
                TD::make('category_id', 'Категория')
                    ->render(function (Site $site) {
                        return $site->category->name;
                    }),
                TD::make('price', 'Награда'),
                TD::make('promo', 'Промокод'),
                TD::make('link', 'Ссылка')
                    ->render(function (Site $site) {
                        return Link::make('Ссылка')
                            ->href($site->link)
                            ->target('_blank');
                    }),
                TD::make('show', 'Отображение')
                    ->render(function (Site $site) {
                        return Button::make($site->show ? 'Выключить' : 'Включить')
                            ->method('toggleSwitchers', [
                                'id' => $site->id,
                                'key' => 'show'
                            ]);
                    }),
                TD::make('new', 'NEW')
                    ->render(function (Site $site) {
                        return Button::make($site->new ? 'Выключить' : 'Включить')
                            ->method('toggleSwitchers', [
                                'id' => $site->id,
                                'key' => 'new'
                            ]);
                    }),
                TD::make('hot', 'HOT')
                    ->render(function (Site $site) {
                        return Button::make($site->hot ? 'Выключить' : 'Включить')
                            ->method('toggleSwitchers', [
                                'id' => $site->id,
                                'key' => 'hot'
                            ]);
                    }),
                TD::make('vpn', 'VPN')
                    ->render(function (Site $site) {
                        return Button::make($site->vpn ? 'Выключить' : 'Включить')
                            ->method('toggleSwitchers', [
                                'id' => $site->id,
                                'key' => 'vpn'
                            ]);
                    }),
                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function (Site $site) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Редактировать'))
                                    ->icon('pencil')
                                    ->route('platform.site.edit', $site->id),

                                Link::make(__('Задания'))
                                    ->icon('pencil')
                                    ->route('platform.site.quest.list', $site->id),

                                Button::make(__('Удалить'))
                                    ->icon('trash')
                                    ->confirm('Удалить данный сайт?')
                                    ->method('remove', [
                                        'id' => $site->id,
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
        DB::transaction(function () use($request) {
            $site = Site::findOrFail($request->get('id'));
            $site->delete();
            Site::where('position', '>', $site->position)->decrement('position');
    
            Toast::info('Сайт успешно удален'); 
        });
    }

    /**
     * @param Request $request
     */
    public function toggleSwitchers(Request $request): void
    {
        DB::transaction(function () use($request) { 
            $site = Site::findOrFail($request->get('id'));
            $key = $request->get('key');

            $site->$key = !$site->$key;
            $site->save();

            Toast::info('Успешно');
        });
    }
}
