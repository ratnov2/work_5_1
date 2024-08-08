<?php

namespace App\Providers;

use App\Containers\Settings\Tasks\GetSettingsApiKeyTask;
use App\Containers\Settings\Tasks\GetSettingsPaymentSystemTask;
use App\Containers\Settings\Tasks\GetSettingsSocialTask;
use Cerbero\LazyJson\Macro;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Faker\Generator::class, function () {
            $faker = \Faker\Factory::create();
            $faker->addProvider(new FakerImageProvider($faker));
            return $faker;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Date::setlocale(config('app.locale'));

        // Dynamic config from DB
        if (!App::environment('testing')) {
            if (Schema::hasTable('settings_api_keys')) {
                $settings = app(GetSettingsApiKeyTask::class)->run();
                Config::set('steam-auth.api_key', $settings?->STEAM_API_KEY);
            }

            if (Schema::hasTable('settings_payment_systems')) {
                $settings = app(GetSettingsPaymentSystemTask::class)->run();
                Config::set('payment.enot.merchant_id', $settings?->ENOT_MERCHANT_ID);
                Config::set('payment.enot.secret_word', $settings?->ENOT_SECRET_WORD);
                Config::set('payment.enot.extra_secret_word', $settings?->ENOT_EXTRA_SECRET_WORD);
            }

            if (Schema::hasTable('settings_socials')) {
                $settings = app(GetSettingsSocialTask::class)->run();
                Config::set('services.vkontakte.client_id', $settings?->VKONTAKTE_CLIENT_ID);
                Config::set('services.vkontakte.client_secret', $settings?->VKONTAKTE_CLIENT_SECRET);
                Config::set('services.telegram.bot_name', $settings?->TELEGRAM_BOT_NAME);
                Config::set('services.telegram.token', $settings?->TELEGRAM_TOKEN);
            }
        }

        if (App::environment('production')) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }

        LazyCollection::macro('fromJson', new Macro());
    }
}
