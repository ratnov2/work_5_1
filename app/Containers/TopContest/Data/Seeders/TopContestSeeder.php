<?php

namespace App\Containers\TopContest\Data\Seeders;

use App\Containers\TopContest\Models\TopContest;
use Illuminate\Database\Seeder;

class TopContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TopContest::create();
    }
}
