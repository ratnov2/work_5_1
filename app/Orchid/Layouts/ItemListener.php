<?php

namespace App\Orchid\Layouts;

use App\Containers\Item\Models\Item;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;

class ItemListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'market_hash_name'
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'filterItems';

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        $item = Item::filters()->limit(10);
        return [
            Layout::rows([
                Select::make('market_hash_name')
                    ->required()
                    ->fromModel($item, 'market_hash_name'),

                DateTimer::make('end_at')
                    ->title('Дата завершения розыгрыша')
                    ->allowInput()
                    ->enableTime()
                    ->required(),

                DateTimer::make('reserved_at')
                    ->title('Дата старта розыгрыша')
                    ->allowInput()
                    ->enableTime()
                    ->required()
            ]),
        ];
    }
}
