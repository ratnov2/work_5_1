<?php

namespace App\Containers\Banner\Data\Seeders;

use App\Containers\Banner\Models\Banner;
use App\Containers\Site\Models\Site;
use App\Containers\Site\Models\SiteCategory;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        $banners[] = [
            'link' => 'http://gribfree.test', 
            'type' => 'top', 
            'image' => $faker->loremflickr('', 2600, 800), 
            'show' => true, 
        ];

        $banners[] = [
            'link' => 'http://gribfree.test', 
            'type' => 'top', 
            'image' => $faker->loremflickr('', 2600, 800), 
            'show' => true, 
        ];

        $banners[] = [
            'link' => 'http://gribfree.test', 
            'type' => 'left', 
            'image' => $faker->loremflickr('', 800, 1900), 
            'show' => true, 
        ];

        $banners[] = [
            'link' => 'http://gribfree.test', 
            'type' => 'left', 
            'image' => $faker->loremflickr('', 800, 1900), 
            'show' => true, 
        ];

        $banners[] = [
            'link' => 'http://gribfree.test', 
            'type' => 'right', 
            'image' => $faker->loremflickr('', 800, 1900), 
            'show' => true, 
        ];
        
        $banners[] = [
            'link' => 'http://gribfree.test', 
            'type' => 'right', 
            'image' => $faker->loremflickr('', 800, 1900), 
            'show' => true, 
        ];
        
        Banner::insert($banners);
    }
}
