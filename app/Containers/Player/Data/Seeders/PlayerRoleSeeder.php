<?php

namespace App\Containers\Player\Data\Seeders;

use App\Containers\Player\Models\PlayerRole;
use Illuminate\Database\Seeder;

class PlayerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Админ',
                'slug' => 'admin'
            ],
            [
                'name' => 'Модератор',
                'slug' => 'moderator'
            ],
            [
                'name' => 'Разработчик',
                'slug' => 'developer'
            ],
            [
                'name' => 'Блоггер',
                'slug' => 'blogger'
            ],
        ];
        
        PlayerRole::insert($roles);
    }
}
