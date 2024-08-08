<?php

namespace App\Containers\GameModes\Data\Seeders;

use App\Containers\GameModes\Models\Banks;
use Illuminate\Database\Seeder;

class GameModesBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *s
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'game_mode' => 'upgrade',
                'value' => 0,
            ],
            [
                'game_mode' => 'boxes_money',
                'value' => 0,
            ],
            [
                'game_mode' => 'mines',
                'value' => 0,
            ],
        ];

        Banks::insert($data);
    }
}
