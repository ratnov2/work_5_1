<?php

namespace App\Containers\Player\Data\Factories;

use App\Containers\Player\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class PlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = app(\Faker\Generator::class);

        return [
            'ref_balance' => 0.00,
            'referrer_id' => NULL,
            'ref_level_id' => 1,
            'name' => $faker->name(),
            'trade_link' => NULL,
            'ref_code' => $faker->randomNumber(9, true),
            'balance' => 0.00,
            'image' => $faker->loremflickr(),
            'steam_id' => $faker->randomNumber(9, true),
            'ban' => 0,
            'withdraw' => 1,
        ];
    }

    public function zeroBalance()
    {
        return $this->state(function (array $attributes) {
            return [
                'ref_balance' => 0.00,
                'balance' => 0.00,
            ];
        });
    }

    public function rich()
    {
        return $this->state(function (array $attributes) {
            return [
                'ref_balance' => 100000000.00,
                'balance' => 10000000.00,
            ];
        });
    }
}