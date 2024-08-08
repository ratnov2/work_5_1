<?php

namespace App\Containers\Item\Tasks;

final class GetItemQualityTask
{
    public function run($market_hash_name) : string
    {
        $market_hash_name = strtolower($market_hash_name);

        $quality = '';

        if (strpos($market_hash_name, 'battle-scarred') !== false) {
            $quality = 'BS';
        } elseif(strpos($market_hash_name, 'well-worn') !== false) {
            $quality = 'WW';
        } elseif(strpos($market_hash_name, 'field-tested') !== false) {
            $quality = 'FT';
        } elseif(strpos($market_hash_name, 'minimal wear') !== false) {
            $quality = 'MW';
        } elseif(strpos($market_hash_name, 'factory new') !== false) {
            $quality = 'FN';
        }

        return $quality;
    }
}
