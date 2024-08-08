<?php

namespace App\Containers\BoxUnique\Data\Seeders;

use App\Containers\BoxUnique\Models\Box;
use Illuminate\Database\Seeder;

class BoxUniqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Box::create(['type' => 'promocodable']);
        Box::create(['type' => 'timerable']);
    }
}
