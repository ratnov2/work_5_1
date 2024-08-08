<?php

namespace App\Orchid\Layouts\Conditions;

use App\Containers\AdSection\VkGroup\Models\VkGroup;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;

class ConditionsLayout extends Rows
{
    protected $target = 'conditionable';

    protected $title = "Условия";

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): array
    {
        $conditionable = $this->query->get('conditionable');

        $action = !is_null($conditionable->condition) ? json_decode($conditionable->condition->action, true) : null;

        return [
            Input::make('condition.action.vk.name')
                ->required()
                ->title('Отоброжаемое имя платформы для VK')
                ->value(isset($action['vk']['name']) ? $action['vk']['name'] : 'VK'),

            Matrix::make('condition.action.vk.subscribes')
                ->value(isset($action['vk']['subscribes']) ? $action['vk']['subscribes'] : [])
                ->title('VK | Подписки')
                ->columns(['Ссылка на группу' => 'link', 'Ссылка на группу для игрока' => 'link_player'])
                ->fields([
                    'link' => Input::make()->placeholder('https://vk.com/clubXXXXXXXX')->type('link'),
                    'link_player' => Input::make()->type('link'),
                ]),

            Matrix::make('condition.action.vk.messages')
                ->value(isset($action['vk']['messages']) ? $action['vk']['messages'] : [])
                ->title('VK | Сообщения')
                ->columns(['Группа' => 'vk_short_name', 'Текст сообщения' => 'text', 'Ссылка для игрока' => 'link_player'])
                ->fields([
                    'vk_short_name' => Select::make()->fromModel(VkGroup::class, 'name', 'vk_short_name'),
                    'text' => Input::make()->type('text'),
                    'link_player' => Input::make()->type('link'),
                ]),

            Matrix::make('condition.action.vk.likes')
                ->value(isset($action['vk']['likes']) ? $action['vk']['likes'] : [])
                ->title('VK | Лайки')
                ->columns(['Ссылка на пост' => 'link', 'Ссылка на пост для игрока' => 'link_player'])
                ->fields([
                    'link' => Input::make()->placeholder('https://vk.com/clubXXXXXXXX?w=wall-XXXXXXXXX_XXXX')->type('link'),
                    'link_player' => Input::make()->type('link'),
                ]),

            Matrix::make('condition.action.vk.reposts')
                ->value(isset($action['vk']['reposts']) ? $action['vk']['reposts'] : [])
                ->title('VK | Репосты')
                ->columns(['Ссылка на пост' => 'link', 'Ссылка на пост для игрока' => 'link_player'])
                ->fields([
                    'link' => Input::make()->placeholder('https://vk.com/clubXXXXXXXX?w=wall-XXXXXXXXX_XXXX')->type('link'),
                    'link_player' => Input::make()->type('link'),
                ]),

            Input::make('condition.action.telegram.name')
                ->required()
                ->title('Отображаемое имя платформы для Telegram')
                ->value(isset($action['telegram']['name']) ? $action['telegram']['name'] : 'Telegram'),

            Matrix::make('condition.action.telegram.subscribes')
                ->value(isset($action['telegram']['subscribes']) ? $action['telegram']['subscribes'] : [])
                ->title('Telegram | Подписки')
                ->columns(['Ссылка на канал' => 'link', 'Ссылка на канал для игрока' => 'link_player'])
                ->fields([
                    'link' => Input::make()->type('link'),
                    'link_player' => Input::make()->type('link'),
                ]),

            Matrix::make('condition.action.any')
                ->help('Если создать ссылки с одним и тем же именем платформы - они будут сгруппированы по этому имени')
                ->value(isset($action['any']) ? $action['any'] : [])
                ->title('Условия без проверок')
                ->columns(['Имя платформы' => 'name', 'Описание условия' => 'desc', 'Ссылка' => 'link'])
                ->fields([
                    'name' => Input::make()->type('text'),
                    'desc' => Input::make()->type('text'),
                    'link' => Input::make()->type('link'),
                ]),
        ];
    }
}
