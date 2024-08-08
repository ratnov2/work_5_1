<?php

namespace App\Containers\Pages\Actions;

use App\Containers\BoxMoney\Models\BoxMoney;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\UI\API\Resources\PlayerItemResource;
use App\Containers\Settings\Tasks\GetSettingsSocialTask;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

final class GetProfileViewAction
{
    public function run()
    {
        $player = app(GetAuthPlayerTask::class)->run();

        $telegram_bot_name = app(GetSettingsSocialTask::class)->run()->TELEGRAM_BOT_NAME;

        $statistics = Cache::remember('profile-info-' . $player->id, 60, function() use($player) {
            $player_favorite_box = $player->items()
                ->where('dropable_type', BoxMoney::class)
                ->select('dropable_id', DB::raw('count(*) as total'))
                ->groupBy('dropable_id')
                ->orderBy('total', 'desc')
                ->first();
            $player_favorite_box = $player_favorite_box ? BoxMoney::find($player_favorite_box->dropable_id) : null;

            $player_best_item = $player->items()
                ->orderBy('price', 'desc')
                ->first();
            $player_best_item = $player_best_item ? (new PlayerItemResource($player_best_item))->toJson() : null;

            return [
                'player_favorite_box' => $player_favorite_box,
                'player_best_item' => $player_best_item,
                'count_boxes' => $player->items()->where('dropable_type', BoxMoney::class)->count(),
                'count_jackpot_bets' => $player->jackpotBets()->count(),
                'count_upgrades' => $player->upgrades()->count(),
            ];
        });

        return View::make("pages::pages.profile.index", [
            'player' => $player,
            'statistics' => $statistics,
            'telegram_bot_name' => $telegram_bot_name
        ])->render();
    }
}
