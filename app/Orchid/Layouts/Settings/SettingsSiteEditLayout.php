<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\Fields\Code;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;

class SettingsSiteEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'settings';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): array
    {
        return [
            Input::make('settings_site.title')
                ->title('Главный заголовок сайта'),

            TextArea::make('settings_site.keywords')
                ->title('Ключевые слова'),

            Picture::make('settings_site.logo')
                ->title('Лого'),

            Picture::make('settings_site.favicon')
                ->title('Фавикон'),

            Input::make('settings_site.youtube_link')
                ->title('Youtube ссылка'),

            Input::make('settings_site.vk_link')
                ->title('Vk ссылка'),

            Input::make('settings_site.telegram_link')
                ->title('Telegram ссылка'),

            Quill::make('settings_site.footer')
                ->title('Описание внизу сайта'),

            Code::make('settings_site.yandex_metrika')
                ->title('Счетчик яндекс метрики'),

            Code::make('settings_site.yandex_metrika_informer')
                ->title('Информер яндекс метрики'),
        ];
    }
}
