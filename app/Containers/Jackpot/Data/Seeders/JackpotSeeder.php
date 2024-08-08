<?php

namespace App\Containers\Jackpot\Data\Seeders;

use App\Containers\Jackpot\Models\Jackpot;
use Illuminate\Database\Seeder;

class JackpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jackpot::create();
    }
}
