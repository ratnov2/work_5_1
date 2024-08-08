<?php

namespace App\Orchid\Layouts\Contest;

use App\Containers\Item\Models\Item;
use Illuminate\Support\Facades\View;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class ContestItemsLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'items';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('market_hash_name', 'Предмет (фильтр по названию)')
                ->filter(TD::FILTER_TEXT)
                ->render(function(Item $item) {
                    return View::make("item::default-card")->with("item", $item)->render();
                }),

            TD::make('price', 'Стоимость')
                ->render(function(Item $item) {
                    return $item->price . " РУБ";
                }),

            TD::make('quality', 'Качество'),
            TD::make('rarity', 'Раритетность'),
        ];
    }
}
