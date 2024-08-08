<?php

namespace App\Containers\Player\Data\Seeders;

use App\Containers\Player\Models\Player;
use App\Containers\Player\Models\PlayerRole;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *s
     * @return void
     */
    public function run()
    {
        Player::factory()
            ->count(1)
            ->rich()
            ->hasAttached(PlayerRole::admin()->first(), [], 'roles')
            ->create();
    }
}
