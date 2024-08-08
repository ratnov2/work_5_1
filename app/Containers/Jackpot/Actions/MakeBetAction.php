<?php

namespace App\Containers\Jackpot\Actions;

use App\Containers\Jackpot\Data\Types\Status;
use App\Containers\Jackpot\DTO\MakeBetDTO;
use App\Containers\Jackpot\Events\UpdateBetsEvent;
use App\Containers\Jackpot\Exceptions\API\JackpotException;
use App\Containers\Jackpot\Models\Jackpot;
use App\Containers\Jackpot\Models\JackpotBet;
use App\Containers\Jackpot\Tasks\CheckStartActivateJackpotTask;
use App\Containers\Jackpot\UI\API\Resources\JackpotBetResource;
use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Tasks\CheckItemsPlayerForReadyTask;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\Tasks\GetItemsPlayerByUniqidsTask;
use App\Containers\Player\Tasks\UpdateItemsPlayerByUniqidsTask;
use Illuminate\Support\Facades\DB;

final class MakeBetAction
{
    public function run(MakeBetDTO $make_bet_dto)
    {
        if(Jackpot::active()->exists() || Jackpot::end()->latest('id')->value('updated_at') > \Carbon\Carbon::now()->subSeconds(5)) {
            throw new JackpotException('В данный момент, ставки не принимаются');
        }

        $player = app(GetAuthPlayerTask::class)->run();
        $uniqids = $make_bet_dto->getUniqids();

        DB::transaction(function () use($player, $uniqids) {
            $jackpot = Jackpot::accessBetting()->lockForUpdate()->first();

            $player_items = app(GetItemsPlayerByUniqidsTask::class)->run(true, ...$uniqids);
            app(CheckItemsPlayerForReadyTask::class)->run($player, ...$player_items);
            app(UpdateItemsPlayerByUniqidsTask::class)->run(
                ['status' => PlayerItemStatus::Jackpot],
                ...$player_items->map(fn($player_item) => $player_item->uniqid),
            );

            // Count tickets
            $items_player_price = $player_items->sum('price');
            if($items_player_price < JackpotBet::MIN_ITEMS_PLAYER_PRICE) throw new JackpotException('Минимальная сумма ставки: ' . JackpotBet::MIN_ITEMS_PLAYER_PRICE . ' монет');
            $tickets = round($items_player_price / JackpotBet::TICKET_COST, 2);
            $last_tickets_to = $jackpot->bets()->latest('tickets_to')->value('tickets_to');
            $tickets_from = $last_tickets_to + 1;
            $tickets_to = $last_tickets_to + $tickets;
            if($tickets_from >= $tickets_to) throw new JackpotException('Ошибка создания ставки. Попробуйте еще раз...');

            $jackpot->bets()->create([
                'player_id' => $player->id,
                'tickets_from' => $tickets_from,
                'tickets_to' => $tickets_to,
                'is_win' => false,
            ])->items()->syncWithoutDetaching($player_items->map(function($player_item) {
                return [
                    'market_hash_name' => $player_item->market_hash_name,
                    'price' => $player_item->price,
                    'item_player_id' => $player_item->id
                ];
            }));

            if($jackpot->status == Status::Wait) app(CheckStartActivateJackpotTask::class)->run($jackpot);
            event(new UpdateBetsEvent(JackpotBetResource::collection($jackpot->bets()->get())));
        });
    }
}
