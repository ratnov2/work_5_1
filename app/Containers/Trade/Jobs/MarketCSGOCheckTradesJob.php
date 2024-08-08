<?php

namespace App\Containers\Trade\Jobs;

use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Trade\Data\Types\Status;
use App\Services\MarketCSGOService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Containers\Trade\Models\Trade;

class MarketCSGOCheckTradesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public $timeout = 36000;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MarketCSGOService $marketcsgo_service)
    {
        try {
            $custom_ids = Trade::processing()->orderBy('updated_at', 'asc')->limit(500)->pluck('custom_id');
            if (count($custom_ids) == 0) return true;

            foreach ($custom_ids->chunk(5) as $custom_ids) {
                $result = $marketcsgo_service->getTradesResult($custom_ids->toArray());
                if (is_null($result)) {
                    Trade::whereIn('custom_id', $custom_ids)->update(['status' => Status::ProccessingFail, 'result' => 'Не удалось получить результат трейда']);
                    continue;
                }
    
                foreach ($result->data as $custom_id => $market_item) {
                    $trade = Trade::where('custom_id', $custom_id)->first();
    
                    if ($market_item->stage == MarketCSGOService::SUCCESS_MARKET_STATUS) { // Успех
                        DB::transaction(function () use ($trade, $market_item) {
                            $trade->status = Status::Success;
                            $trade->result = 'Выведен!';
                            $trade->paid = $market_item->paid;
                            $trade->save();
                            DB::table('item_player')->where('id', $trade->item_player_id)->update(['status' => PlayerItemStatus::Trade]);
                        });
                    } elseif ($market_item->stage == MarketCSGOService::ERROR_MARKET_STATUS) { // Ошибка
                        DB::transaction(function () use ($trade) {
                            $trade->status = Status::Fail;
                            $trade->result = 'Тайм-аут';
                            $trade->save();
                            DB::table('item_player')->where('id', $trade->item_player_id)->update(['status' => PlayerItemStatus::Ready]);
                        });
                    } elseif ($market_item->stage == MarketCSGOService::WAITING_MARKET_STATUS) { // Ожидание
                        $trade->result = 'Все еще в обработке';
                        $trade->save();
                    }
                }
            }
        } catch (\Throwable $th) {
            $this->fail($th);
        }
    }
}
