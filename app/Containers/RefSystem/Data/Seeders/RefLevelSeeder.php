<?php

namespace App\Containers\RefSystem\Data\Seeders;

use App\Containers\RefSystem\Models\RefLevel;
use Illuminate\Database\Seeder;

class RefLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefLevel::create([
            'id' => 1,
            'sum_payments' => 0,
            'level' => 1,
            'bonus_precent' => 5.00,
            'ref_bonus_precent' => 5.00,
            'type' => 'standart',
        ]);

        RefLevel::create([
            'id' => 2,
            'sum_payments' => 100,
            'level' => 2,
            'bonus_precent' => 7.00,
            'ref_bonus_precent' => 7.00,
            'type' => 'standart',
        ]);
    }
}
