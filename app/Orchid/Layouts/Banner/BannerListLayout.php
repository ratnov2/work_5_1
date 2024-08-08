<?php

namespace App\Orchid\Layouts\Banner;

use Orchid\Screen\TD;
use App\Containers\Banner\Models\Banner;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class BannerListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'banners';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')->render(function (Banner $banner) {
                return Link::make($banner->id)
                    ->route('platform.banner.edit', $banner);
                }),
            TD::make('image', 'Изображение')
                ->cantHide()
                ->width(200)
                ->render(function (Banner $banner) {
                    return '<img style="width: 100%" src="' . $banner->image . '" alt="box" />';
                }),
            TD::make('type', 'Расположение')
                ->render(function (Banner $banner) {
                    switch ($banner->type) {
                        case 'top':
                            return 'Сверху';
                        case 'left':
                            return 'Слева';
                        case 'right':
                            return 'Справа';
                    }
                }),
            TD::make('show', 'Отображение')
                ->render(function (Banner $banner) {
                    return Button::make($banner->show ? 'Выключить' : 'Включить')
                        ->method('toggleSwitchers', [
                            'id' => $banner->id,
                            'key' => 'show'
                        ]);
                }),
            TD::make('created_at', 'Создан')
                ->render(function (Banner $banner) {
                    return $banner->human_created_at;
                }),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Banner $banner) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Редактировать'))
                                ->icon('pencil')
                                ->route('platform.banner.edit', $banner->id),

                            Button::make(__('Удалить'))
                                ->icon('trash')
                                ->confirm('Удалить этот баннер?')
                                ->method('remove', [
                                    'id' => $banner->id,
                                ]),
                        ]);
                }),
        ];
    }
}
