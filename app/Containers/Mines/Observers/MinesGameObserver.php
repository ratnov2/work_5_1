<?php

namespace App\Containers\Mines\Observers;

use App\Containers\Mines\Data\Types\Status;
use App\Containers\Mines\Models\MinesGame;
use App\Containers\Mines\UI\API\Resources\HistoryMinesGameResource;
use denis660\Centrifugo\Centrifugo;

class MinesGameObserver
{
    /**
     * Handle the Article "updated" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function updated(MinesGame $mines_game)
    {
        if($mines_game->status == Status::END) {
            $history_item = new HistoryMinesGameResource($mines_game);
            app(Centrifugo::class)->publish('public:mines-history', ['history_item' => $history_item]);
        }
    }
}
