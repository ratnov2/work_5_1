<?php

namespace App\Containers\Mines\Actions;

use App\Containers\GameModes\Tasks\GetBankMinesTask;
use App\Containers\Mines\Data\Types\Status;
use App\Containers\Mines\Tasks\GenerateMinesCellIndexesTask;
use App\Containers\Mines\UI\API\Exceptions\MinesException;
use App\Containers\Mines\Tasks\GetCoefficientsByCountMinesTask;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use Illuminate\Support\Facades\DB;

final class OpenCellAction
{
    public function run(int $cell_index)
    {
        return DB::transaction(function () use($cell_index) {
            $player = app(GetAuthPlayerTask::class)->run(is_locked:true);
            $bank = app(GetBankMinesTask::class)->run(is_locked:true);
            
            $mines_game = $player->minesGames()->inGame()->first();
            if(!$mines_game) throw new MinesException('У вас еще нет начатой игры');

            $coefficients = app(GetCoefficientsByCountMinesTask::class)->run($mines_game->count_mines);
            $cell_results = $mines_game->cell_results ?? [];
            $next_step = count($cell_results);

            $bet_amount = $mines_game->bets->map(fn($bet) => $bet->playerItem)->sum('price');
            $current_win_amount = $next_step == 0 ? 0 : $bet_amount * $coefficients[$next_step - 1];
            $next_win_amount = $bet_amount * $coefficients[$next_step];

            $bank->value += $current_win_amount;

            $result_params = [];

            // Fail
            if($bank->value < $next_win_amount) {
                $cell_results[$cell_index] = false;

                foreach (app(GenerateMinesCellIndexesTask::class)->run($cell_results, $mines_game->count_mines) as $mine_cell_index)
                    $cell_results[$mine_cell_index] = false;

                $mines_game->fill(['status' => Status::END]);
            }

            // Next
            if($bank->value >= $next_win_amount) {
                $cell_results[$cell_index] = true;

                $bank->value -= $next_win_amount;

                // Win
                if($this->_checkLastStep($coefficients, $next_step)) {
                    foreach (app(GenerateMinesCellIndexesTask::class)->run($cell_results, $mines_game->count_mines) as $mine_cell_index)
                        $cell_results[$mine_cell_index] = false;

                    $mines_game->fill(['win_amount' => $next_win_amount, 'balance' => $next_win_amount, 'status' => Status::END]);
        
                    $player->balance += $next_win_amount;
                    $player->save();

                    $result_params['player_balance'] = $player->balance;
                }
            }

            $bank->save();
            
            $mines_game->fill(['cell_results' => $cell_results]);
            $mines_game->save();

            $result_params['mines_game'] = $mines_game;
            return $result_params;
        });
    }

    private function _checkLastStep($coefficients, $next_step) {
        return $coefficients[$next_step] == end($coefficients);
    }
}
