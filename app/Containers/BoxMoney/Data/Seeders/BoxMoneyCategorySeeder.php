<?php

namespace App\Containers\BoxMoney\Data\Seeders;

use App\Containers\BoxMoney\Models\BoxMoneyCategory;
use Illuminate\Database\Seeder;

class BoxMoneyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoxMoneyCategory::create([
            'name' => 'TEST',
            'position' => 1
        ]);
    }
}
