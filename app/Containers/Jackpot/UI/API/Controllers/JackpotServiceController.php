<?php

namespace App\Containers\Jackpot\UI\API\Controllers;

use App\Containers\Jackpot\Data\Types\Status;
use App\Containers\Jackpot\Events\NewJackpotDropEvent;
use App\Containers\Jackpot\Events\NewJackpotHistory;
use App\Containers\Jackpot\Exceptions\API\JackpotException as JackpotApiException;
use App\Containers\Jackpot\Models\Jackpot;
use App\Containers\Item\Models\Item;
use App\Containers\Jackpot\UI\API\Resources\JackpotHistoryResource;
use App\Containers\Player\Events\SendStorePlayerEvent;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use App\Containers\Player\UI\API\Resources\PlayerItemResource;
use App\Containers\Player\UI\API\Resources\SafePlayerResource;
use App\Containers\Settings\Tasks\GetSettingsJackpotTask;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class JackpotServiceController extends Controller
{
    public function ping()
    {
        try {
            return response()->json([
                'status' => 'success',
                'status_jackpot' => Jackpot::latest('id')->value('status')
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage()
            ]);
        }
    }

    public function active()
    {
        DB::beginTransaction();
        try {
            $jackpot = Jackpot::accessBetting()->lockForUpdate()->first();
            if(!$jackpot) throw new \Exception('Access betting Jackpot not found');

            $bets = $jackpot->bets()->lockForUpdate()->get();
            $tickets_from = $bets->min('tickets_from');
            $tickets_to = $bets->max('tickets_to');

            $win_ticket = rand($tickets_from, $tickets_to);
            $win_bet = $jackpot->bets()->where([['tickets_from', '<=', $win_ticket], ['tickets_to', '>=', $win_ticket]])->first();
            $win_bet->is_win = true;
            $win_bet->save();

            $jackpot->win_ticket = $win_ticket;
            $jackpot->status = Status::Active;
            $jackpot->save();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'win_ticket' => $win_ticket,
                'win_player' => new SafePlayerResource($win_bet->player)
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            if($th instanceof JackpotApiException) throw $th;
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage()
            ]);
        }
    }

    public function end()
    {
        DB::beginTransaction();
        try {
            $jackpot = Jackpot::active()->lockForUpdate()->first();
            if(!$jackpot) throw new JackpotApiException('Active Jackpot not found');

            $settings_jackpot = app(GetSettingsJackpotTask::class)->run();

            $bank = $jackpot->bets->reduce(fn($sum, $bet) => $sum + $bet->items->sum('pivot.price'), 0);
            $win_bank = round($bank * (100 - $settings_jackpot->profit_precent) / 100, 2);
            $win_bet = $jackpot->bets->firstWhere('is_win', true);
            $win_player = $win_bet->player()->lockForUpdate()->first();

            $win_item = Item::latest('price')->where('price', '<=', $win_bank)->first();
            $win_balance = $win_bank - $win_item->price > 0 ? $win_bank - $win_item->price : 0;
            $win_player->balance += $win_balance;
            $win_player->save();

            $player_item = app(AddDropablePlayerItemsSubAction::class)->run($win_player, $jackpot, $win_item)[0];

            $jackpot->fill([
                'bank' => $bank,
                'win_item_price' => $win_item->price,
                'win_balance' => $win_balance,
                'profit' => $bank - $win_bank,
                'status' => Status::End,
            ])->save();

            $next_jackpot = Jackpot::create(['status' => Status::Wait]);

            DB::commit();
            
            event(new SendStorePlayerEvent($win_player->id, balance:$win_player->balance, add_player_items:[new PlayerItemResource($player_item)], msg:'Вы выиграли в JACKPOT #' . $jackpot->id));
            event(new NewJackpotHistory(new JackpotHistoryResource($jackpot)));
            event(new NewJackpotDropEvent($win_player, $win_item));

            return response()->json([
                'status' => 'success',
                'next_jackpot_id' => $next_jackpot->id
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            if($th instanceof JackpotApiException) throw $th;
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage()
            ]);
        }
    }
}
