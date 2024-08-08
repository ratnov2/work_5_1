<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            \App\Containers\Settings\Data\Seeders\SettingsSeeder::class,
            \App\Containers\RefSystem\Data\Seeders\RefLevelSeeder::class,
            \App\Containers\Item\Data\Seeders\ItemSeeder::class,
            \App\Containers\Player\Data\Seeders\PlayerRoleSeeder::class,
            \App\Containers\Player\Data\Seeders\PlayerSeeder::class,
            \App\Containers\User\Data\Seeders\UserSeeder::class,
            \App\Containers\Jackpot\Data\Seeders\JackpotSeeder::class,
            \App\Containers\GameModes\Data\Seeders\GameModesBankSeeder::class,
            \App\Containers\TopContest\Data\Seeders\TopContestSeeder::class,
            \App\Containers\BoxUnique\Data\Seeders\BoxUniqueSeeder::class,
        ]);
    }
}
