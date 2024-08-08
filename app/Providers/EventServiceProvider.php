<?php

namespace App\Providers;

use App\Containers\Banner\Models\Banner;
use App\Containers\Banner\Observers\BannerObserver;
use App\Containers\Bonus\Listeners\GiveRewardForAttachSocialListener;
use App\Containers\Box\Events\NewBoxDropEvent;
use App\Containers\Contest\Models\Contest;
use App\Containers\Contest\Observers\ContestObserver;
use App\Containers\Jackpot\Events\NewJackpotDropEvent;
use App\Containers\Jackpot\Models\Jackpot;
use App\Containers\Jackpot\Observers\JackpotObserver;
use App\Containers\LiveDrops\Listeners\OnNewBoxDropListener;
use App\Containers\LiveDrops\Listeners\OnNewJackpotDropListener;
use App\Containers\LiveDrops\Listeners\OnNewUpgradeDropListener;
use App\Containers\Mines\Models\MinesGame;
use App\Containers\Mines\Observers\MinesGameObserver;
use App\Containers\PaymentSection\Payment\Events\PaymentSuccessPaid;
use App\Containers\Player\Events\IPlayerAttachSocialAccount;
use App\Containers\Site\Models\Site;
use App\Containers\Site\Observers\SiteObserver;
use App\Containers\Player\Events\PlayerRegisteredEvent;
use App\Containers\RefSystem\Listeners\AttachReferalListener;
use App\Containers\RefSystem\Listeners\RewardToReferrerListener;
use App\Containers\RefSystem\Models\RefLevel;
use App\Containers\RefSystem\Observers\RefLevelObserver;
use App\Containers\Settings\Models\SettingsApiKey;
use App\Containers\Settings\Models\SettingsBox;
use App\Containers\Settings\Models\SettingsJackpot;
use App\Containers\Settings\Models\SettingsSite;
use App\Containers\Settings\Models\SettingsSocial;
use App\Containers\Settings\Models\SettingsTopContest;
use App\Containers\Settings\Models\SettingsUpgrade;
use App\Containers\Settings\Observers\SettingsApiKeysObserver;
use App\Containers\Settings\Observers\SettingsBoxObserver;
use App\Containers\Settings\Observers\SettingsJackpotObserver;
use App\Containers\Settings\Observers\SettingsSiteObserver;
use App\Containers\Settings\Observers\SettingsSocialObserver;
use App\Containers\Settings\Observers\SettingsTopContestObserver;
use App\Containers\Settings\Observers\SettingsUpgradeObserver;
use App\Containers\Site\Models\SiteCategory;
use App\Containers\Site\Observers\SiteCategoryObserver;
use App\Containers\Upgrade\Events\NewUpgradeDropEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        PlayerRegisteredEvent::class => [
            AttachReferalListener::class,
        ],

        PaymentSuccessPaid::class => [
            RewardToReferrerListener::class,
        ],

        IPlayerAttachSocialAccount::class => [
            GiveRewardForAttachSocialListener::class
        ],

        NewBoxDropEvent::class => [
            OnNewBoxDropListener::class
        ],

        NewUpgradeDropEvent::class => [
            OnNewUpgradeDropListener::class
        ],

        NewJackpotDropEvent::class => [
            OnNewJackpotDropListener::class
        ],

        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            \SocialiteProviders\Telegram\TelegramExtendSocialite::class.'@handle',
            \SocialiteProviders\VKontakte\VKontakteExtendSocialite::class.'@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Contest::observe(ContestObserver::class);
        Banner::observe(BannerObserver::class);
        Site::observe(SiteObserver::class);
        SiteCategory::observe(SiteCategoryObserver::class);
        RefLevel::observe(RefLevelObserver::class);
        Jackpot::observe(JackpotObserver::class);
        MinesGame::observe(MinesGameObserver::class);

        SettingsSite::observe(SettingsSiteObserver::class);
        SettingsSocial::observe(SettingsSocialObserver::class);
        SettingsApiKey::observe(SettingsApiKeysObserver::class);
        SettingsBox::observe(SettingsBoxObserver::class);
        SettingsUpgrade::observe(SettingsUpgradeObserver::class);
        SettingsJackpot::observe(SettingsJackpotObserver::class);
        SettingsTopContest::observe(SettingsTopContestObserver::class);
    }
}
