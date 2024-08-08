<?php

declare(strict_types=1);

use App\Orchid\Screens\Banner\BannerEditScreen;
use App\Orchid\Screens\Banner\BannerListScreen;
use App\Orchid\Screens\BoxLimit\BoxesLimitScreen;
use App\Orchid\Screens\BoxLimit\BoxLimitScreen;
use App\Orchid\Screens\BoxMoney\BoxesMoneyScreen;
use App\Orchid\Screens\BoxMoney\BoxMoneyScreen;
use App\Orchid\Screens\BoxMoneyCategory\BoxMoneyCategoriesScreen;
use App\Orchid\Screens\BoxMoneyCategory\BoxMoneyCategoryScreen;
use App\Orchid\Screens\BoxPromocode\PromocodePackScreen as BoxPromocodePackScreen;
use App\Orchid\Screens\BoxPromocode\ConditionsScreen as BoxPromocodeConditionsScreen;
use App\Orchid\Screens\BoxPromocode\SettingsScreen as BoxPromocodeSettingsScreen;
use App\Orchid\Screens\BoxPromocode\PromocodesScreen as BoxPromocodePromocodesScreen;
use App\Orchid\Screens\BoxPromocode\PromocodeScreen as BoxPromocodePromocodeScreen;
use App\Orchid\Screens\BoxTimer\ConditionsScreen as BoxTimerConditionsScreen;
use App\Orchid\Screens\BoxTimer\SettingsScreen as BoxTimerSettingsScreen;
use App\Orchid\Screens\SiteCategory\SiteCategoryEditScreen;
use App\Orchid\Screens\SiteCategory\SiteCategoryListScreen;
use App\Orchid\Screens\Contest\ContestEditScreen;
use App\Orchid\Screens\Contest\ContestListScreen;
use App\Orchid\Screens\PaymentSystem\PaymentListScreen;
use App\Orchid\Screens\PaymentSystem\PaymentPromocodeEditScreen;
use App\Orchid\Screens\PaymentSystem\PaymentPromocodeListScreen;
use App\Orchid\Screens\Player\PlayerEditScreen;
use App\Orchid\Screens\Player\PlayerListScreen;
use App\Orchid\Screens\RefSystem\RefLevelsCustomEditScreen;
use App\Orchid\Screens\RefSystem\RefLevelsListScreen;
use App\Orchid\Screens\RefSystem\RefLevelsEditScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Settings\SettingsEditScreen;
use App\Orchid\Screens\Site\SiteEditScreen;
use App\Orchid\Screens\Site\SiteListScreen;
use App\Orchid\Screens\Statistics\StatisticsScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\PlayerSiteQuest\PlayerSiteQuestListScreen;
use App\Orchid\Screens\PlayerSiteQuest\PlayerSiteQuestScreen;
use App\Orchid\Screens\SiteQuest\SiteQuestEditScreen;
use App\Orchid\Screens\SiteQuest\SiteQuestListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

// Main
Route::screen('/', PlatformScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail;
    })
    ->name('platform.index');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{roles}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Platform > Site > Quest > List
Route::screen('site/{site}/quests', SiteQuestListScreen::class)
    ->name('platform.site.quest.list');

// Platform > Site > Quest > Edit
Route::screen('site/{site}/quest/{quest?}', SiteQuestEditScreen::class)
    ->name('platform.site.quest.edit');

// Platform > Player Site Quest > List
Route::screen('player-site-quests', PlayerSiteQuestListScreen::class)
    ->name('platform.player-site-quest.list');

// Platform > Player Site Quest > Show
Route::screen('player-site-quest/{player_site_quest}', PlayerSiteQuestScreen::class)
    ->name('platform.player-site-quest');

// Platform > Site > List
Route::screen('sites', SiteListScreen::class)
    ->name('platform.site.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Сайты'), route('platform.site.list'));
    });

// Platform > Site > Edit
Route::screen('site/{site?}', SiteEditScreen::class)
    ->name('platform.site.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.site.list')
            ->push(__('Редактирование'), route('platform.site.edit'));
    });

// Platform > SiteCategory > List
Route::screen('site-categories', SiteCategoryListScreen::class)
    ->name('platform.site-category.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Категории'), route('platform.site-category.list'));
    });

// Platform > SiteCategory > Edit
Route::screen('site-category/{category?}', SiteCategoryEditScreen::class)
    ->name('platform.site-category.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.site-category.list')
            ->push(__('Редактирование'), route('platform.site-category.edit'));
    });

// Platform > Banner > List
Route::screen('banners', BannerListScreen::class)
    ->name('platform.banner.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Категории'), route('platform.banner.list'));
    });

// Platform > Banner > Edit
Route::screen('banner/{banner?}', BannerEditScreen::class)
    ->name('platform.banner.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.banner.list')
            ->push(__('Редактирование'), route('platform.banner.edit'));
    });

// Platform > Contest > List
Route::screen('contests', ContestListScreen::class)
    ->name('platform.contest.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Конкурсы'), route('platform.contest.list'));
    });

// Platform > Contest > Edit
Route::screen('contest/{contest?}', ContestEditScreen::class)
    ->name('platform.contest.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.contest.list')
            ->push(__('Редактирование'), route('platform.contest.edit'));
    });

// Platform > Player > List
Route::screen('players', PlayerListScreen::class)
    ->name('platform.player.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Игроки'), route('platform.player.list'));
    });

// Platform > Player > Edit
Route::screen('player/{player?}', PlayerEditScreen::class)
    ->name('platform.player.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.player.list')
            ->push(__('Редактирование'), route('platform.player.edit'));
    });

// Platform > Setting > Edit
Route::screen('settings', SettingsEditScreen::class)
    ->name('platform.settings.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Настройки'), route('platform.settings.edit'));
    });

// Platform > RefLevels > List
Route::screen('ref-levels', RefLevelsListScreen::class)
    ->name('platform.ref-level.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Реферальный уровни'), route('platform.ref-level.list'));
    });

// Platform > RefLevels > Edit
Route::screen('ref-level/{ref_level?}', RefLevelsEditScreen::class)
    ->name('platform.ref-level.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.ref-level.list')
            ->push(__('Создание/Редактирование'), route('platform.ref-level.edit'));
    });

// Platform > RefLevels > Custom Edit
Route::screen('ref-custom-level/{ref_level?}', RefLevelsCustomEditScreen::class)
    ->name('platform.ref-custom-level.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.ref-level.list')
            ->push(__('Кастомный уровень'), route('platform.ref-custom-level.edit'));
    });

// Platform > BoxesLimit
Route::screen('boxes-limit', BoxesLimitScreen::class)
    ->name('platform.boxes-limit');

// Platform > BoxLimit > Edit
Route::screen('box-limit/{box_limit?}', BoxLimitScreen::class)
    ->name('platform.box-limit');

// Platform > BoxesMoney
Route::screen('boxes-money', BoxesMoneyScreen::class)
    ->name('platform.boxes-money');

// Platform > BoxMoney > Edit
Route::screen('box-money/{box_money?}', BoxMoneyScreen::class)
    ->name('platform.box-money');

// Platform > BoxMoneyCategories
Route::screen('box-money-categories', BoxMoneyCategoriesScreen::class)
    ->name('platform.box-money-categories');

// Platform > BoxMoneyCategory > Edit
Route::screen('box-money-category/{box_money_category?}', BoxMoneyCategoryScreen::class)
    ->name('platform.box-money-category');

// Platform > BoxTimer > Settings
Route::screen('box-timer/settings', BoxTimerSettingsScreen::class)
    ->name('platform.box-timer.settings');

// Platform > BoxTimer > Conditions
Route::screen('box-timer/conditions', BoxTimerConditionsScreen::class)
    ->name('platform.box-timer.conditions');

// Platform > BoxPromocode > Settings
Route::screen('box-promocode/settings', BoxPromocodeSettingsScreen::class)
    ->name('platform.box-promocode.settings');

// Platform > BoxPromocode > Conditions
Route::screen('box-promocode/conditions', BoxPromocodeConditionsScreen::class)
    ->name('platform.box-promocode.conditions');

// Platform > BoxPromocode > Promocodes
Route::screen('box-promocode/promocodes', BoxPromocodePromocodesScreen::class)
    ->name('platform.box-promocode.promocodes');

// Platform > BoxPromocode > Promocodes > Edit
Route::screen('box-promocode/promocode/{box_promocode?}', BoxPromocodePromocodeScreen::class)
    ->name('platform.box-promocode.promocode');

// Platform > BoxPromocode > Promocodes > Pack
Route::screen('box-promocode/promocodes/pack', BoxPromocodePackScreen::class)
    ->name('platform.box-promocode.promocodes.pack');

Route::get('/file/download/box-promocodes', [\App\Orchid\Controllers\DownloadFileController::class, 'downloadBoxPromocodes'])
    ->name('platform.file.download.box-promocodes');

// Platform > PaymentPromocode > List
Route::screen('payment-promocodes', PaymentPromocodeListScreen::class)
    ->name('platform.payment-promocode.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Промокоды для пополнений'), route('platform.payment-promocode.list'));
    });

// Platform > PaymentPromocode > Edit
Route::screen('payment-promocode/{payment_promocode?}', PaymentPromocodeEditScreen::class)
    ->name('platform.payment-promocode.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.payment-promocode.list')
            ->push(__('Создание/Редактирование'), route('platform.payment-promocode.edit'));
    });

// Platform > Statistics
Route::screen('statistics', StatisticsScreen::class)
    ->name('platform.statistics')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Сатистика'), route('platform.statistics'));
    });

// Platform > Payment > List
Route::screen('payments', PaymentListScreen::class)
    ->name('platform.payment.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Платежи'), route('platform.payment.list'));
    });
