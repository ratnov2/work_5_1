<?php

namespace App\Orchid\Layouts\Contest;

use App\Containers\Contest\Data\Types\Status;
use Orchid\Screen\TD;
use App\Containers\Contest\Models\Contest;
use Illuminate\Support\Facades\View;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class ContestListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'contests';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('position', 'Позиция'),
            TD::make('win_player_id', 'Победитель')
                ->render(function(Contest $contest) {
                    return is_null($contest->win_player) ? 'Победитель не определен' : Link::make($contest->win_player->name)->href('/admin/players?filter[steam_id]=' . $contest->win_player->steam_id);
                }),
            TD::make('market_hash_name', 'Предмет')
                ->filter(TD::FILTER_TEXT)
                ->render(function(Contest $contest) {
                    return View::make("item::default-card")->with("item", $contest->item)->render();
                }),

            TD::make('type', 'Тип')
                ->render(function(Contest $contest) {
                    switch ($contest->type) {
                        case 'default':
                            return 'Обычный';
                        case 'sponsor':
                            return 'Спонсорский';
                        default:
                            return 'Неопределенный тип';
                    }
                }),
            TD::make('count_players', 'Кол-во участников')
                ->render(function(Contest $contest) {
                    return $contest->players->count();
                }),
            TD::make('status', 'Статус')
                ->render(function(Contest $contest) {
                    switch ($contest->status) {
                        case Status::Wait:
                            return 'Ожидание старта';
                        case Status::Active:
                            return 'Идет розыгрыш';
                        case Status::Finish:
                            return 'Розыгрыш завершен';
                    }
                }),
            TD::make('reserved_at', 'Начнется')
                ->render(function(Contest $contest) {
                    return \Carbon\Carbon::parse($contest->reserved_at)->setTimezone('Europe/Moscow');
                }),
            TD::make('end_at', 'Закончится')
                ->render(function(Contest $contest) {
                    return \Carbon\Carbon::parse($contest->end_at)->setTimezone('Europe/Moscow');
                }),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Contest $contest) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Редактировать'))
                                ->icon('pencil')
                                ->route('platform.contest.edit', $contest->id),

                            Button::make(__('Удалить'))
                                ->icon('trash')
                                ->method('remove', [
                                    'id' => $contest->id,
                                ]),
                        ]);
                }),
        ];
    }
}
