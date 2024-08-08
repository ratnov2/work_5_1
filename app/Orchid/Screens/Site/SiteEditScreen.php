<?php

namespace App\Orchid\Screens\Site;

use App\Containers\Site\Models\SiteCategory;
use App\Containers\Site\Models\Site;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Support\Facades\Layout;

class SiteEditScreen extends Screen
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
    public function query(Site $site): array
    {
        $this->exists = $site->exists;

        if($this->exists) $this->name = 'Редактирование';

        return [
            'site' => $site
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
        $positions = Site::orderBy('position')->pluck('position');
        if(!$this->exists) $positions->push($positions->count() + 1);

        foreach ($positions as $position)
            $options[$position] = $position;

        return [
            Layout::rows([
                Select::make('site.position')
                    ->options($options)
                    ->empty('Не выбрано')
                    ->title('Позиция')
                    ->help('Позиция, на которой будет находиться сайт')
                    ->required(),

                Input::make('site.link')
                    ->title('Ссылка на сайт')
                    ->required(),

                Input::make('site.price')
                    ->title('Награда')
                    ->required(),

                Select::make('site.category_id')
                    ->fromModel(SiteCategory::class, 'name', 'id')
                    ->title('Имя категории')
                    ->help('Укажите категорию, к которой относится сайт'),

                Quill::make('site.instruction')
                    ->title('Инструкция'),

                Picture::make('site.image')
                    ->required(),

                Input::make('site.promo')
                    ->title('Промокод'),

                Switcher::make('site.show')
                    ->title('Отображать?')
                    ->sendTrueOrFalse(),

                Switcher::make('site.new')
                    ->title('NEW?')
                    ->sendTrueOrFalse(),

                Switcher::make('site.hot')
                    ->title('HOT?')
                    ->sendTrueOrFalse(),

                Switcher::make('site.vpn')
                    ->title('VPN?')
                    ->sendTrueOrFalse(),
            ])
        ];
    }

    public function create(Site $site, Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->get('site');

            Site::where('position', '>=', $params['position'])->orderBy('position', 'desc')->increment('position');

            $site->fill($params);
            $site->save();

            Alert::info('Успешное создание сайта');

            DB::commit();
            return redirect()->route('platform.site.list');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(Site $site, Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->get('site');

            $site->position < $params['position']
                ? Site::where([['position', '<=', $params['position']], ['position', '>', $site->position]])->decrement('position')
                : Site::where([['position', '>=', $params['position']], ['position', '<', $site->position]])->increment('position');

            $site->fill($params);
            $site->save();

            Alert::info('Успешное обновление сайта');

            DB::commit();
            return redirect()->route('platform.site.list');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * @param Site $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Site $site)
    {
        DB::beginTransaction();
        try {
            $site->delete();
            Site::where('position', '>', $site->position)->decrement('position');

            Alert::info('Сайт успешно удален');

            DB::commit();
            return redirect()->route('platform.site.list');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
