<?php

namespace App\Containers\Item\Tasks;

final class GetItemRarityTask
{
    public function run($ru_rarity, $market_hash_name) : string
    {
        $rarity = 'common';

        if ($ru_rarity == "Ширпотреб" || $ru_rarity == "базового класса" || $ru_rarity == "Consumer Grade" || $ru_rarity == "Base Grade") {
            $rarity = 'common';
        } elseif ($ru_rarity == "Промышленное качество" || $ru_rarity == "Industrial Grade") {
            $rarity = 'uncommon';
        } elseif ($ru_rarity == "Высшего класса" || $ru_rarity == "высшего класса" || $ru_rarity == "High Grade" || $ru_rarity == "Mil-Spec Grade" || $ru_rarity == "Армейское качество" || $ru_rarity == "Distinguished") {
            $rarity = 'milspec';
        } elseif ($ru_rarity == "Remarkable" || $ru_rarity == "Restricted" || $ru_rarity == "Запрещенное" || $ru_rarity == "Запрещённое") {
            $rarity = 'restricted';
        } elseif ($ru_rarity == "Classified" || $ru_rarity == "экзотичного вида" || $ru_rarity == "Засекреченное" || $ru_rarity == "Превосходный") {
            $rarity = 'classified';
        } elseif ($ru_rarity == "Covert" || $ru_rarity == "Extraordinary" || $ru_rarity == "экстраординарного типа" || $ru_rarity == "Тайное" || $ru_rarity == "Мастерский") {
            $rarity = 'covert';
        } elseif (strpos($market_hash_name, 'Knife') !== false) {
            $rarity = 'rare';
        }

        return $rarity;
    }
}
