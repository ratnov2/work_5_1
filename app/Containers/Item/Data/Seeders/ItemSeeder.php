<?php

namespace App\Containers\Item\Data\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'app/Containers/Item/Data/Seeders/items.sql';
        DB::unprepared(file_get_contents($path));
    }
}
