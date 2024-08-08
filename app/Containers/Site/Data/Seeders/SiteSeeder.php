<?php

namespace App\Containers\Site\Data\Seeders;

use App\Containers\Site\Models\Site;
use App\Containers\Site\Models\SiteCategory;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        $site_category = SiteCategory::create([
            'position' => 1,
            'name' => 'TEST CATEGORY'
        ]);

        for ($i = 1; $i <= 10; $i++) { 
            $sites[] = [
                'position' => $i,
                'price' => '10', 
                'link' => 'http://gribfree.test', 
                'image' => $faker->loremflickr('', 260, 80), 
                'promo' => 'XXX-XXX', 
                'category_id' => $site_category->id, 
                'show' => true, 
                'new' => true, 
                'hot' => true, 
                'vpn' => true,
            ];
        }
        
        Site::insert($sites);
    }
}
