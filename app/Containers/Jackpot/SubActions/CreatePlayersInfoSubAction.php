<?php

namespace App\Containers\Jackpot\SubActions;

use App\Containers\Jackpot\Events\StartJackpotEvent;
use App\Containers\Jackpot\Models\Jackpot;
use App\Containers\Jackpot\Tasks\GetJackpotBankTask;

final class CreatePlayersInfoSubAction
{
    private $backgroundColor = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(64, 255, 246, 1)',
        'rgba(243, 64, 255, 1)',
        'rgba(64, 255, 88, 1)',
        'rgba(199, 30, 66, 1)',
        'rgba(30, 51, 199, 1)',
        'rgba(196, 30, 199, 1)',
        'rgba(118, 30, 199, 1)',
        "rgba(250, 197, 153, 1)",
        'rgba(30, 199, 82, 1)',
        "rgba(18, 170, 138, 1)",
        "rgba(218, 170, 96, 1)",
        "rgba(12, 184, 222, 1)",
        "rgba(209, 24, 207, 1)",
        "rgba(186, 160, 116, 1)",
        "rgba(171, 250, 59, 1)",
        "rgba(201, 34, 143, 1)",
        "rgba(164, 177, 45, 1)",
        "rgba(14, 34, 103, 1)",
        "rgba(140, 94, 72, 1)",
        "rgba(29, 174, 39, 1)",
        "rgba(254, 79, 30, 1)",
        "rgba(25, 100, 146, 1)",
        "rgba(154, 215, 142, 1)",
        "rgba(248, 26, 8, 1)",
        "rgba(90, 228, 200, 1)",
        "rgba(153, 44, 106, 1)",
        "rgba(71, 191, 251, 1)",
        "rgba(255, 32, 137, 1)",
        "rgba(175, 1, 190, 1)",
        "rgba(195, 130, 24, 1)",
        "rgba(90, 96, 218, 1)",
        "rgba(112, 29, 241, 1)",
        "rgba(88, 3, 211, 1)",
        "rgba(81, 43, 21, 1)",
        "rgba(8, 197, 138, 1)",
        "rgba(196, 35, 232, 1)",
        "rgba(126, 36, 245, 1)",
        "rgba(155, 219, 228, 1)",
        "rgba(62, 44, 181, 1)",
        "rgba(216, 167, 230, 1)",
        "rgba(152, 186, 32, 1)",
        "rgba(7, 42, 77, 1)",
        "rgba(193, 8, 238, 1)",
        "rgba(56, 11, 64, 1)",
        "rgba(195, 48, 74, 1)",
        "rgba(75, 58, 17, 1)",
        "rgba(20, 144, 163, 1)",
        "rgba(60, 212, 15, 1)",
        "rgba(195, 213, 163, 1)",
        "rgba(200, 88, 201, 1)",
        "rgba(236, 10, 18, 1)",
        "rgba(174, 216, 92, 1)",
        "rgba(81, 146, 18, 1)",
        "rgba(209, 231, 250, 1)",
        "rgba(176, 106, 188, 1)",
        "rgba(81, 158, 138, 1)",
        "rgba(170, 45, 132, 1)",
        "rgba(195, 78, 124, 1)",
        "rgba(244, 29, 150, 1)",
        "rgba(192, 90, 161, 1)",
        "rgba(146, 255, 67, 1)",
        "rgba(118, 28, 168, 1)",
        "rgba(214, 74, 218, 1)",
        "rgba(3, 135, 213, 1)",
        "rgba(203, 164, 25, 1)",
        "rgba(136, 199, 118, 1)",
        "rgba(125, 66, 74, 1)",
        "rgba(8, 222, 158, 1)",
        "rgba(29, 250, 113, 1)",
        "rgba(9, 49, 0, 1)",
        "rgba(188, 174, 131, 1)",
        "rgba(108, 43, 245, 1)",
        "rgba(96, 40, 91, 1)",
        "rgba(82, 109, 184, 1)",
        "rgba(102, 72, 98, 1)",
        "rgba(253, 187, 131, 1)",
        "rgba(136, 83, 248, 1)",
        "rgba(164, 159, 113, 1)",
        "rgba(134, 99, 231, 1)",
        "rgba(161, 116, 24, 1)",
        "rgba(107, 99, 244, 1)",
        "rgba(251, 102, 17, 1)",
        "rgba(215, 16, 30, 1)",
        "rgba(167, 164, 74, 1)",
        "rgba(160, 39, 63, 1)",
        "rgba(107, 108, 68, 1)",
        "rgba(246, 90, 198, 1)",
        "rgba(196, 14, 126, 1)",
        "rgba(85, 190, 176, 1)",
        "rgba(1, 235, 159, 1)",
        "rgba(177, 164, 207, 1)",
        "rgba(228, 146, 250, 1)",
        "rgba(50, 76, 137, 1)",
        "rgba(225, 182, 44, 1)",
        "rgba(48, 12, 244, 1)",
        "rgba(185, 5, 124, 1)",
        "rgba(153, 4, 126, 1)",
        "rgba(70, 220, 87, 1)",
        "rgba(254, 171, 183, 1)",
        "rgba(184, 119, 91, 1)",
        "rgba(184, 96, 189, 1)",
        "rgba(27, 210, 20, 1)",
        "rgba(205, 120, 240, 1)",
        "rgba(14, 74, 16, 1)",
        "rgba(232, 227, 169, 1)",
        "rgba(95, 229, 181, 1)",
        "rgba(41, 109, 9, 1)",
    ];

    private $radius = 300;

    public function run($jackpot)
    {
        try {
            // $prev_sum_precent = 0;
            // $bank = app(GetJackpotBankTask::class)->run($jackpot);

            // $players_info = $jackpot->bets->groupBy(function ($bet, $key) {
            //     return $bet->player->id;
            // })->map(function($player_bets) {
            //     $player_info = [
            //         "sum" => $player_bets->sum('sum'),
            //         "player" => $bet->player,
            //         "timestamp" => $bet->created_at->timestamp,
            //     ];
            //     $deg = ($prev_sum_precent + $player_info.precent / 2) * 3.6;
            //     $coodrinate = $this->getCoordinateOnCircleByDeg($deg - 90);
            //     $player_info['avatar_deg'] = $deg;
            //     $player_info['color'] = $this->backgroundColor[$index];
            //     $player_info['transform_style'] = "{transform: translate(" . $coodrinate['x'] . "px, " . $coodrinate['y'] . "px)}";
            //     $prev_sum_precent += $player_info->precent;
            // })->values();

            // return $players_info;

        } catch (\Throwable $th) {
            return false;
        }
    }

    private function getCoordinateOnCircleByDeg($deg) {
        $angle = pi() * $deg / 180;
        $x = $this->radius * cos($angle);
        $y = $this->radius * sin($angle);
        return ['x' => $x, 'y' => $y];
    }
}
