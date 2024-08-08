<?php

namespace App\Containers\BoxMoney\Data\Seeders;

use App\Containers\BoxMoney\Models\BoxMoney;
use Illuminate\Database\Seeder;

class BoxMoneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        BoxMoney::create([
            'name' => 'TEST BOX',
            'image' => $faker->loremflickr(),
            'price' => 10,
            'category_id' => 1, 
            'profit_precent' => 10
        ]);
    }
}
