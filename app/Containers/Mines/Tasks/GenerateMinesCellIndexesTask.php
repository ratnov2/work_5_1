<?php

namespace App\Containers\Mines\Tasks;

final class GenerateMinesCellIndexesTask
{
    public function run($cell_results, $count_mines)
    {
        $avaiable_mines_cell_indexes = [];

        for ($i = 1; $i <= 5; $i++) {
            for ($k = 1; $k <= 5; $k++) {
                $cell_index = $k + 5 * ($i - 1);

                if (!isset($cell_results[$cell_index])) {
                    $avaiable_mines_cell_indexes[] = $cell_index;
                } elseif($cell_results[$cell_index] == false) {
                    $count_mines--;
                }
            }
        }

        shuffle($avaiable_mines_cell_indexes);

        return array_slice($avaiable_mines_cell_indexes, 0, $count_mines);
    }
}
