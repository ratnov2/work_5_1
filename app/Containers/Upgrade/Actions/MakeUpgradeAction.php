<?php

namespace App\Containers\Upgrade\Actions;

use App\Containers\GameModes\Tasks\GetBankUpgradeTask;
use App\Containers\Item\Tasks\GetItemByMarketHashNameTask;
use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Upgrade\DTO\MakeUpgradeDTO;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use App\Containers\Player\Tasks\CheckItemsPlayerForReadyTask;
use App\Containers\Upgrade\Tasks\CreateUpgradeTask;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\Tasks\GetItemsPlayerByUniqidsTask;
use App\Containers\Player\Tasks\UpdateItemsPlayerByUniqidsTask;
use App\Containers\Player\UI\API\Resources\PlayerItemResource;
use App\Containers\Settings\Tasks\GetSettingsUpgradeTask;
use App\Containers\Upgrade\Events\NewUpgradeDropEvent;
use App\Containers\Upgrade\UI\API\Exceptions\MakeUpgradeException;
use Illuminate\Support\Facades\DB;

final class MakeUpgradeAction
{
    const MAX_CHANCE = 95;
    const MIN_CHANCE = 5;

    public function run(MakeUpgradeDTO $dto)
    {
        $wanted_market_hash_name = $dto->getWanted_market_hash_name();
        $wanted_item = app(GetItemByMarketHashNameTask::class)->run($wanted_market_hash_name);
        if(!$wanted_item) throw new MakeUpgradeException($wanted_market_hash_name . ', в данный момент, не найден. Попробуйте позже');

        $settings_upgrade = app(GetSettingsUpgradeTask::class)->run();
        $player = app(GetAuthPlayerTask::class)->run();

        $bet_uniqid = $dto->getUniqid();
        $sync_chance = $dto->getSync_chance();

        return DB::transaction(function() use($player, $bet_uniqid, $sync_chance, $settings_upgrade, $wanted_item) {
            $player_item = app(GetItemsPlayerByUniqidsTask::class)->run(true, $bet_uniqid)[0];
            app(CheckItemsPlayerForReadyTask::class)->run($player, $player_item);
            app(UpdateItemsPlayerByUniqidsTask::class)->run(['status' => PlayerItemStatus::Upgrade], $player_item->uniqid);

            $chance = round($player_item->price * 100 / $wanted_item->price, 2);
            if(round($sync_chance, 2) !== round($chance, 2)) throw new MakeUpgradeException('Цена желаемого предмета обновилась. Пожалуйста, выберите другой предмет или обновите поиск');
            if($chance < self::MIN_CHANCE || $chance > self::MAX_CHANCE) throw new MakeUpgradeException("Желаемый предмет должен быть в пределах " . self::MIN_CHANCE . "-" . self::MAX_CHANCE . "% от стоимости вашего предмета");

            $bank_upgrade = app(GetBankUpgradeTask::class)->run(is_locked:true);
            $bank_upgrade->value += ($player_item->price * (100 - $settings_upgrade->profit_precent)) / 100;
            $is_success = $wanted_item->price <= $bank_upgrade->value && rand(0, 100) > 20;
            if($is_success) $bank_upgrade->value -= $wanted_item->price;
            $bank_upgrade->save();

            $upgrade = app(CreateUpgradeTask::class)->run([
                'player_id' => $player->id,
                'item_player_id' => $player_item->id,
                'wanted_market_hash_name' => $wanted_item->market_hash_name,
                'chance' => $chance,
                'profit' => $player_item->price * $settings_upgrade->profit_precent / 100,
                'result' => $is_success,
            ]);

            if($is_success) {
                $player_item = app(AddDropablePlayerItemsSubAction::class)->run($player, $upgrade, $wanted_item)[0];
                event(new NewUpgradeDropEvent($player, $wanted_item));
                $player_item = new PlayerItemResource($player_item);
            }

            return [
                'player_item' => $player_item ?? null,
                'is_success' => $is_success,
                'arrow_deg' => $is_success ? rand(0, $chance) * 3.6 : rand(0, 100 - $chance) * 3.6 + $chance * 3.6,
            ];
        });
    }
}
