<?php

namespace App\Containers\PaymentSection\PaymentSystem\Data\Seeders;

use App\Containers\PaymentSection\PaymentSystem\Models\PaymentSystem;
use App\Containers\PaymentSection\PaymentSystem\Models\PaymentSystemCategory;
use App\Containers\PaymentSection\PaymentSystem\Models\PaymentSystemDirection;
use Illuminate\Database\Seeder;

class PaymentSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentSystem::insert([
            [
                'id' => 1,
                'name' => 'Enot',
                'slug' => 'enot',
            ],
        ]);

        PaymentSystemDirection::insert([
            [
                'id' => 1,
                'name' => 'Enot',
                'image' => 'https://enot.io/themes/site/img/methods/svg/logo-qiwi.svg',
                'id_in_payment_system' => NULL,
                'payment_system_id' => 1,
                'is_active' => 1,
                'is_need_sum' => 1,
            ],
        ]);

        PaymentSystemCategory::insert([
            [
                'id' => 1,
                'name' => 'Карты',
                'slug' => 'cards',
            ],
            [
                'id' => 2,
                'name' => 'Электронные кошельки',
                'slug' => 'wallets',
            ],
            [
                'id' => 3,
                'name' => 'Криптовалюта',
                'slug' => 'crypt',
            ],
            [
                'id' => 4,
                'name' => 'Скины',
                'slug' => 'skins',
            ],
        ]);
    }
}
