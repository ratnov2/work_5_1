<?php

namespace App\Containers\SiteQuest\Data\Seeders;

use App\Containers\SiteQuest\Models\SiteQuest;
use Illuminate\Database\Seeder;

class SiteQuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        for ($i = 1; $i <= 3; $i++) { 
            $data[] = [
                'site_id' => 1,
                'name' => $faker->name(),
                'description' => $faker->paragraph(),
                'is_active' => true,
                'reward_price' => 5,
                'is_wait_work_answer_required' => true,
                'is_wait_done_answer_required' => true,
                'end_at' => null,
            ];
        }
        
        SiteQuest::insert($data);
    }
}
