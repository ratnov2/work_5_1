<?php

namespace App\Orchid\Screens\Settings;

use App\Containers\Settings\Tasks\GetSettingsApiKeyTask;
use App\Containers\Settings\Tasks\GetSettingsJackpotTask;
use App\Containers\Settings\Tasks\GetSettingsPaymentSystemTask;
use App\Containers\Settings\Tasks\GetSettingsSiteTask;
use App\Containers\Settings\Tasks\GetSettingsSocialTask;
use App\Containers\Settings\Tasks\GetSettingsTopContestTask;
use App\Containers\Settings\Tasks\GetSettingsUpgradeTask;
use App\Orchid\Layouts\Settings\SettingsApiKeyEditLayout;
use App\Orchid\Layouts\Settings\SettingsJackpotEditLayout;
use App\Orchid\Layouts\Settings\SettingsPaymentSystemEditLayout;
use App\Orchid\Layouts\Settings\SettingsSiteEditLayout;
use App\Orchid\Layouts\Settings\SettingsTopContestEditLayout;
use App\Orchid\Layouts\Settings\SettingsUpgradeEditLayout;
use App\Orchid\Layouts\Settings\SettingsSocialEditLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;

class SettingsEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Обновление настроек';

    private $get_settings_tasks;

    public function __construct() {
        $this->get_settings_tasks = [
            'settings_payment_system' => app(GetSettingsPaymentSystemTask::class),
            'settings_social' => app(GetSettingsSocialTask::class),
            'settings_site' => app(GetSettingsSiteTask::class),
            'settings_api_key' => app(GetSettingsApiKeyTask::class),
            'settings_top_contest' => app(GetSettingsTopContestTask::class),
            'settings_jackpot' => app(GetSettingsJackpotTask::class),
            'settings_upgrade' => app(GetSettingsUpgradeTask::class),
        ];
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $query = [];

        foreach ($this->get_settings_tasks as $key => $task) {
            $query[$key] = $task->run();
        }

        return $query;
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::block(SettingsPaymentSystemEditLayout::class)
                ->title('Настройки платежной системы')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save', ['settings_payment_system'])
                ),

            Layout::block(SettingsSocialEditLayout::class)
                ->title('Настройки соц. сетей')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save', ['settings_social'])
                ),

            Layout::block(SettingsApiKeyEditLayout::class)
                ->title('Настройки апи-ключей')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save', ['settings_api_key'])
                ),

            Layout::block(SettingsTopContestEditLayout::class)
                ->title('Настройки топа игроков')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save', ['settings_top_contest'])
                ),

            Layout::block(SettingsUpgradeEditLayout::class)
                ->title('Настройки апгрейда')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save', ['settings_upgrade'])
                ),

            Layout::block(SettingsJackpotEditLayout::class)
                ->title('Настройки джекпота')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save', ['settings_jackpot'])
                ),

            Layout::block(SettingsSiteEditLayout::class)
                ->title('Настройки сайта')
                ->description('Мета информация о сайте')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save', ['settings_site'])
                ),
        ];
    }

    public function save(Request $request)
    {
        $settings_key = $request->query()[0];

        $params = $request->get($settings_key);

        $settings_model = $this->get_settings_tasks[$settings_key]->run();
        $settings_model->fill($params);
        $settings_model->save();

        Alert::info('Настройки обновлены');

        return redirect()->route('platform.settings.edit');
    }
}
