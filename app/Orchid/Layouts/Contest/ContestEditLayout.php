<?php

namespace App\Orchid\Layouts\Contest;

use App\Containers\Contest\Models\Contest;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Rows;

class ContestEditLayout extends Rows
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
    protected function fields(): array
    {
        $items = $this->query->get('items');
        $contest = $this->query->get('contest');

        // Предметы
        $options_items = [];
        foreach ($items as $item)
            $options_items[$item->market_hash_name] = $item->market_hash_name;
        if(!is_null($contest->item)) $options_items[$contest->item->market_hash_name] = $contest->item->market_hash_name;

        // Позиция
        $positions = Contest::orderBy('position')->pluck('position');
        if(!$contest->exists) $positions->push(Contest::count() + 1);
        $positions->sortDesc();

        $options_positions = [];
        foreach ($positions as $position)
            $options_positions[$position] = $position;

        return [
            Select::make('contest.position')
                    ->options($options_positions)
                    ->empty('Не выбрано')
                    ->title('Позиция')
                    ->help('Позиция, на которой будет находиться розыгрыш')
                    ->required(),

            Select::make('contest.market_hash_name')
                ->title('Выберите искомый предмет из списка')
                ->options($options_items)
                ->required(),

            Select::make('contest.type')
                ->title('Выберите тип розыгрыша')
                ->options([
                    'default' => 'Обычный',
                    'sponsor' => 'Спонсорский'
                ])
                ->required(),

            DateTimer::make('contest.reserved_at')
                ->title('Дата старта розыгрыша (время МСК)')
                ->value(\Carbon\Carbon::now('Europe/Moscow'))
                ->allowInput()
                ->enableTime()
                ->required(),

            DateTimer::make('contest.end_at')
                ->title('Дата завершения розыгрыша (время МСК)')
                ->value(\Carbon\Carbon::now('Europe/Moscow')->addDay(1))
                ->allowInput()
                ->enableTime()
                ->required(),
        ];
    }
}
