<?php

namespace App\Containers\Settings\Data\Seeders;

use App\Containers\Settings\Models\SettingsApiKey;
use App\Containers\Settings\Models\SettingsBox;
use App\Containers\Settings\Models\SettingsJackpot;
use App\Containers\Settings\Models\SettingsPaymentSystem;
use App\Containers\Settings\Models\SettingsSite;
use App\Containers\Settings\Models\SettingsSocial;
use App\Containers\Settings\Models\SettingsTopContest;
use App\Containers\Settings\Models\SettingsUpgrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            SettingsBox::create([
                'box_timer' => true,
                'box_promocode' => true,
                'box_timer_max_item_price' => 0.70,
                'box_promocode_max_item_price' => 0.70,
                'box_timer_min_sum_payments_time_day' => 0
            ]);
            SettingsPaymentSystem::create([]);
            SettingsSocial::create([]);
            SettingsApiKey::create([]);
            SettingsJackpot::create([
                'profit_precent' => 10.00,
                'is_active' => true,
            ]);
            SettingsUpgrade::create([
                'profit_precent' => 10.00,
                'is_active' => true,
            ]);
            SettingsSite::create([]);
            SettingsTopContest::create([
                'first_place_sum' => 300,
                'second_place_sum' => 200,
                'third_place_sum' => 100,
                'every_hours' => 24,
            ]);
        });
    }
}
