<?php

namespace App\Orchid\Layouts\Player;

use Orchid\Screen\TD;
use App\Containers\Player\Models\Player;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class PlayerListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'players';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')->sort(),
            TD::make('image', 'Аватарка')
                ->cantHide()
                ->width(100)
                ->render(function (Player $player) {
                    return '<img style="width: 100%" src="' . $player->image . '" alt="box" />';
                }),
            TD::make('steam_id', 'Steam ID')
                ->filter(TD::FILTER_TEXT)
                ->sort(),
            TD::make('name', 'Имя')
                ->filter(TD::FILTER_TEXT)
                ->sort(),
            TD::make('player.ref_level', 'Реферальный уровень')
                ->render(function (Player $player) {
                    return $player->ref_level->full;
                }),

            TD::make('balance', 'Баланс')
                ->sort()
                ->render(function (Player $player) {
                    return $player->balance . ' РУБ';
                }),
            TD::make('ref_balance', 'Реф. баланс')
                ->sort()
                ->render(function (Player $player) {
                    return $player->ref_balance . ' РУБ';
                }),
            TD::make('withdraw', 'Выводы')
                ->render(function (Player $player) {
                    return $player->withdraw ? 'Открыты' : 'Закрыты';
                }),
            TD::make('withdraw', 'Статус')
                ->render(function (Player $player) {
                    return $player->ban ? 'Забанен' : 'Не забанен';
                }),
            TD::make('created_at', 'Зарегистрирован')
                ->render(function (Player $player) {
                    return $player->human_created_at;
                }),
            TD::make('updated_at', 'Обновлен')
                ->render(function (Player $player) {
                    return $player->human_updated_at;
                }),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Player $player) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Редактировать')
                                ->route('platform.player.edit', $player),

                            Button::make('Заблокировать')
                                ->canSee(!$player->ban)
                                ->method('ban', [
                                    'id' => $player->id,
                                ]),
                            Button::make('Разблокировать')
                                ->canSee($player->ban)
                                ->method('unban', [
                                    'id' => $player->id,
                                ]),
                            Button::make('Открыть выводы')
                                ->canSee(!$player->withdraw)
                                ->method('openWithdraw', [
                                    'id' => $player->id,
                                ]),
                            Button::make('Закрыть выводы')
                                ->canSee($player->withdraw)
                                ->method('closeWithdraw', [
                                    'id' => $player->id,
                                ]),
                        ]);
                }),
        ];
    }
}
