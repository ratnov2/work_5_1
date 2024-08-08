<?php

namespace App\Containers\Withdraw\Actions;

use App\Containers\Item\Tasks\GetItemByMarketHashNameTask;
use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Tasks\CheckItemsPlayerForReadyTask;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\Tasks\GetItemsPlayerByUniqidsTask;
use App\Containers\Player\Tasks\UpdateItemsPlayerByUniqidsTask;
use App\Containers\Trade\Data\Types\Status;
use App\Containers\Trade\Models\Trade;
use App\Containers\Withdraw\DTO\ItemWithdrawDTO;
use App\Containers\Withdraw\DTO\MarketCSGOBuyForDTO;
use App\Containers\Withdraw\UI\API\Exceptions\ItemWithdrawException;
use App\Containers\Withdraw\Tasks\GetPartnerFromTradeLinkTask;
use App\Containers\Withdraw\Tasks\GetTokenFromTradeLinkTask;
use App\Services\MarketCSGOService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class ItemWithdrawAction
{
    private $marketcsgo_service;

    public function __construct(MarketCSGOService $marketcsgo_service) {
        $this->marketcsgo_service = $marketcsgo_service;
    }

    public function run(ItemWithdrawDTO $make_withdraw_dto)
    {
        $player = app(GetAuthPlayerTask::class)->run();
        if (!$player->withdraw) throw new ItemWithdrawException('Для вас выводы не доступны');
        if (is_null($player->trade_link)) throw new ItemWithdrawException('Не задана trade-ссылка');
        $uniqid = $make_withdraw_dto->getUniqid();

        $trade = DB::transaction(function() use($uniqid, $player) {
            $player_item = app(GetItemsPlayerByUniqidsTask::class)->run(true, $uniqid)[0];

            app(CheckItemsPlayerForReadyTask::class)->run($player, $player_item);
            app(UpdateItemsPlayerByUniqidsTask::class)->run(['status' => PlayerItemStatus::TradeProccess], $player_item->uniqid);

            $item = app(GetItemByMarketHashNameTask::class)->run($player_item->market_hash_name);
            if(!$item) throw new ItemWithdrawException('Данный предмет временно недоступен для вывода');
            if($item->price_market > $player_item->price ) throw new ItemWithdrawException('Цена данного предмета сильно изменилась! Попробуйте подождать или продать и купить новый предмет!');

            $trade = Trade::where('item_player_id', $player_item->id)->first();
            if(!$trade) {
                $trade = Trade::create([
                    'item_player_id' => $player_item->id,
                    'market_hash_name' => $player_item->market_hash_name,
                    'price' => $item->price_market,
                    'custom_id' => Str::random(50),
                    'status' => Status::Wait,
                    'result' => 'Трейд ждет вывода',
                ]);
            } else {
                $trade->fill([
                    'market_hash_name' => $player_item->market_hash_name,
                    'price' => $item->price_market,
                    'status' => Status::Wait,
                    'result' => 'Трейд ждет вывода',
                ]);
                $trade->save();
            };

            return $trade;
        });

        try {
            $result = $this->marketcsgo_service->buyFor(app(MarketCSGOBuyForDTO::class)->fromArray([
                'hash_name' => $trade->market_hash_name,
                'price' => $trade->price * 100,
                'custom_id' => $trade->custom_id,
                'partner' => app(GetPartnerFromTradeLinkTask::class)->run($player->trade_link),
                'token' => app(GetTokenFromTradeLinkTask::class)->run($player->trade_link),
            ]));
        } catch (\Throwable $th) {
            $msg = "Ошибка оформления заявки на вывод...";
            $this->error($uniqid, $trade, $msg);
            throw new ItemWithdrawException($msg);
        }

        if(!$result['success']) {
            $this->error($uniqid, $trade, $result['msg']);
            throw new ItemWithdrawException($result['msg']);
        }

        $trade->fill(['status' => Status::Proccessing, 'result' => 'Трейд в обработке']);
        $trade->save();
    }

    public function error($uniqid, $trade, $msg)
    {
        DB::transaction(function() use($uniqid, $trade, $msg) {
            app(UpdateItemsPlayerByUniqidsTask::class)->run(['status' => PlayerItemStatus::Ready], $uniqid);
            $trade->fill(['status' => Status::Fail, 'result' => $msg]);
            $trade->save();
        });
    }
}
