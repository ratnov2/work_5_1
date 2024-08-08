<?php

namespace App\Containers\Mines\Tasks;

final class GetCoefficientsByCountMinesTask
{
    public function run(int $count_mines)
    {
        $arr = [];

        $o = 1;
        $a = 0.05;

        for ($i = 0; $i < 25 - $count_mines; $i++) {
            $s = ($o *= (25 - $i) / (25 - $count_mines - $i)) - $o * $a;
            $c = floor(100 * $s) / 100;
            $arr[] = $c;
        }

        return $arr;
    }
}
