<?php

namespace App\Orchid\Screens\Banner;

use App\Containers\Banner\Models\Banner;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Picture;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class BannerEditScreen extends Screen
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
    public function query(Banner $banner): array
    {
        $this->exists = $banner->exists;

        if($this->exists){
            $this->name = 'Редактирование';
        }

        return [
            'banner' => $banner
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
        return [
            Layout::rows([
                Select::make('banner.type')
                    ->empty('Не выбрано')
                    ->title('Место')
                    ->options([
                        'left' => 'Слева',
                        'top' => 'Сверху',
                        'right' => 'Справа'
                    ])->required(),

                Picture::make('banner.image')
                    ->title('Изображение')
                    ->required(),

                Input::make('banner.link')
                    ->title('Ссылка')
                    ->required(),

                CheckBox::make('banner.show')
                    ->sendTrueOrFalse()
                    ->title('Отображать?')

            ])
        ];
    }

    public function createOrUpdate(Banner $banner, Request $request)
    {
        $params = $request->get('banner');

        $banner->fill($params);
        $banner->save();

        Alert::info('Успешное обновление баннера');

        return redirect()->route('platform.banner.list');
    }

    public function remove(Banner $banner)
    {
        $banner->delete();

        Alert::info('Баннер успешно удален');

        return redirect()->route('platform.site.list');
    }
}
