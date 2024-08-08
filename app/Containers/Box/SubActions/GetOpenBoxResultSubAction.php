<?php

namespace App\Containers\Box\SubActions;

use App\Containers\Item\Tasks\GetItemLikeMarketHashNameTask;
use App\Containers\Item\Tasks\GetRandomItemsBetweenTask;
use App\Containers\Item\UI\API\Resources\ItemResource;
use App\Containers\Player\UI\API\Resources\PlayerItemResource;

final class GetOpenBoxResultSubAction
{
    const COUNT_DROP_LINE_ITEMS = 109;

    public function run($mode, $win_item, $player_item, $price) : array
    {
        $result = [
            'win_item' => new ItemResource($win_item),
            'player_item' => new PlayerItemResource($player_item),
        ];

        if($mode == 'normal') {
            $min = $price * 0.5;
            $max = $price * 20;

            $drop_line_items = app(GetRandomItemsBetweenTask::class)->run($min, $max, self::COUNT_DROP_LINE_ITEMS);
            $result['drop_line_items'] = ItemResource::collection($drop_line_items);
            $result['drop_line_items'][floor(self::COUNT_DROP_LINE_ITEMS / 2)] = new ItemResource($win_item);

            if(rand(0, 20) === 0) {
                $rand_position = rand(0, 1) === 0
                    ? rand(floor(self::COUNT_DROP_LINE_ITEMS / 2) - 2, floor(self::COUNT_DROP_LINE_ITEMS / 2) - 1)
                    : rand(floor(self::COUNT_DROP_LINE_ITEMS / 2) + 1, floor(self::COUNT_DROP_LINE_ITEMS / 2) + 2);

                $rich_item = app(GetItemLikeMarketHashNameTask::class)->run('Knife');
                $result['drop_line_items'][$rand_position] = new ItemResource($rich_item);
            }
        }

        return $result;
    }
}
