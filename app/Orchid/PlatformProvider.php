<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Статистика')
                ->route('platform.statistics'),

            Menu::make('Сайты')
                ->route('platform.site.list'),

            Menu::make('Категории сайтов')
                ->route('platform.site-category.list'),

            Menu::make('Проверка заданий сайтов')
                ->route('platform.player-site-quest.list'),

            Menu::make('Платежная система')
                ->list([
                    Menu::make('Список платежей')->route('platform.payment.list'),
                    Menu::make('Промокоды к депозиту')->route('platform.payment-promocode.list'),
                ]),

            Menu::make('Конкурсы')
                ->route('platform.contest.list'),

            Menu::make('Кейс Таймер')
                ->list([
                    Menu::make('Настройки')->route('platform.box-timer.settings'),
                    Menu::make('Условия')->route('platform.box-timer.conditions'),
                ]),

            Menu::make('Кейс Промокод')
                ->list([
                    Menu::make('Настройки')->route('platform.box-promocode.settings'),
                    Menu::make('Промокоды')->route('platform.box-promocode.promocodes'),
                    Menu::make('Условия')->route('platform.box-promocode.conditions'),
                ]),

            Menu::make('Кейсы Лимит')
                ->route('platform.boxes-limit'),

            Menu::make('Кейсы Деньги')
                ->list([
                    Menu::make('Категории')->route('platform.box-money-categories'),
                    Menu::make('Список кейсов')->route('platform.boxes-money'),
                ]),

            Menu::make('Баннеры')
                ->route('platform.banner.list'),

            Menu::make('Игроки')
                ->route('platform.player.list'),

            Menu::make('Реферальные уровни')
                ->route('platform.ref-level.list'),

            Menu::make('Настройки')
                ->route('platform.settings.edit'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
