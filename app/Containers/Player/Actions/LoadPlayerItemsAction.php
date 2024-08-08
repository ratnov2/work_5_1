<?php

namespace App\Containers\Player\Actions;

use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\UI\API\Resources\PlayerItemResource;

final class LoadPlayerItemsAction
{
    public function run() : array
    {
        $player = app(GetAuthPlayerTask::class)->run();

        $paginator = $player->items()->orderBy('id', 'desc')->cursorPaginate(20);

        return [
            'items' => PlayerItemResource::collection($paginator->items()),
            'next_items_url' => $paginator->nextPageUrl(),
            'has_more_items' => $paginator->hasMorePages(),
        ];
    }
}
