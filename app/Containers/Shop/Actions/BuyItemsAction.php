<?php

namespace App\Containers\Shop\Actions;

use App\Containers\Item\Tasks\GetItemByMarketHashNameTask;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use App\Containers\Player\SubActions\SellItemsPlayerSubAction;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\UI\API\Resources\PlayerItemResource;
use App\Containers\Shop\DTO\BuyItemsDTO;
use App\Containers\Shop\Tasks\CreateShopPurchaceTask;
use App\Containers\Shop\UI\API\Exceptions\ShopException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class BuyItemsAction
{
    public function run(BuyItemsDTO $dto) : array
    {
        DB::beginTransaction();
        try {
            $extra_uniqids = $dto->getExtra_uniqids();
            $market_hash_names_with_quantity = $dto->getMarket_hash_names_with_quantity();

            $player = app(GetAuthPlayerTask::class)->run(is_locked:true);
            $player = app(SellItemsPlayerSubAction::class)->run($player, ...$extra_uniqids);

            $selected_items = self::getSelectedItems($market_hash_names_with_quantity);
            $selected_items_price = $selected_items->sum('price');

            if($player->balance < $selected_items_price) throw new ShopException('Не хватает средств!');
            $player->balance -= $selected_items_price;
            $player->save();

            // Success purchase
            $market_hash_names = $selected_items->map(fn($selected_item) => $selected_item->market_hash_name)->toArray();
            $shop_purchase = app(CreateShopPurchaceTask::class)->run($player, $market_hash_names, $selected_items_price);
            $player_items = app(AddDropablePlayerItemsSubAction::class)->run($player, $shop_purchase, ...$selected_items);

            DB::commit();
            return [
                'player_items' => PlayerItemResource::collection($player_items),
                'player_balance' => $player->balance,
            ];

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    private static function getSelectedItems($market_hash_names_with_quantity) : Collection
    {
        $selected_items = [];
        foreach ($market_hash_names_with_quantity as $market_hash_name_with_quantity) {
            if($market_hash_name_with_quantity['quantity'] <= 0) throw new ShopException('Кол-во предметов должно быть больше 0');
            $item = app(GetItemByMarketHashNameTask::class)->run($market_hash_name_with_quantity['market_hash_name']);
            if(!$item) throw new ShopException($market_hash_name_with_quantity['market_hash_name'] . " не найден");
            for ($i = 0; $i < $market_hash_name_with_quantity['quantity']; $i++) $selected_items[] = $item;
        }
        return collect($selected_items);
    }
}
