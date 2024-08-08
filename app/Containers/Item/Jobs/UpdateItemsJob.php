<?php

namespace App\Containers\Item\Jobs;

use App\Containers\Item\Models\Item;
use App\Containers\Item\Tasks\GetItemQualityTask;
use App\Containers\Item\Tasks\GetItemRarityTask;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class UpdateItemsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const PRECENT_TO_PRICE = 20;

    public $tries = 3;

    public $timeout = 3600;

    public function handle()
    {
        try {
            $source = 'https://market.csgo.com/api/v2/prices/class_instance/RUB.json';

            $get_item_rarity_task = app(GetItemRarityTask::class);
            $get_item_quality_task = app(GetItemQualityTask::class);

            $lazyCollection = LazyCollection::fromJson($source, 'items')
                ->map(function ($item, $class_instance) use($get_item_rarity_task, $get_item_quality_task) {
                    return [
                        'market_hash_name' => $item['market_hash_name'],
                        'ru_market_hash_name' => $item['ru_name'],
                        'price' => $item['price'] + ($item['price'] * self::PRECENT_TO_PRICE / 100),
                        'price_market' => $item['price'],
                        'quantity' => 1,
                        'quality' => $get_item_quality_task->run($item['market_hash_name']),
                        'rarity' => $get_item_rarity_task->run($item['ru_rarity'], $item['market_hash_name']),
                        'class_instance' => $class_instance
                    ];
                });

            $items = self::getUniqueItems($lazyCollection);

            self::updateDB($items);

        } catch (\Throwable $th) {
            $this->fail($th);
        }
    }

    private static function getUniqueItems($collection) : array {
        $items = [];
        foreach ($collection as $item) {
            if (isset($items[$item['market_hash_name']])) {
                $items[$item['market_hash_name']]['quantity']++;

                if ($items[$item['market_hash_name']]['price'] > $item['price']) {
                    $items[$item['market_hash_name']]['price'] = $item['price'];
                    $items[$item['market_hash_name']]['price_market'] = $item['price_market'];
                }

                continue;
            }
            $items[$item['market_hash_name']] = $item;
        }
        return $items;
    }

    private static function updateDB(array $items) : void {
        DB::transaction(function () use($items) {
            $should_not_update_market_hash_names = Item::where('is_updatable', false)->pluck('market_hash_name')->toArray();
            $items = collect($items)->filter(fn($item) => !in_array($item['market_hash_name'], $should_not_update_market_hash_names))->all();
            $avaiable_market_hash_names = array_keys($items);

            Item::whereIn('market_hash_name', $avaiable_market_hash_names)->delete();
            Item::whereNotIn('market_hash_name', array_merge($avaiable_market_hash_names, $should_not_update_market_hash_names))->update(['quantity' => 0]);
            $chunks = array_chunk($items, 500);
            foreach ($chunks as $chunk)
                Item::insert($chunk);
        });
    }
}
