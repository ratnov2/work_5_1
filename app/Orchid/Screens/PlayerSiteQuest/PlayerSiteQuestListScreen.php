<?php

namespace App\Orchid\Screens\PlayerSiteQuest;

use App\Containers\SiteQuest\Models\PlayerSiteQuest;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class PlayerSiteQuestListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Квесты игроков';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все квесты';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'player_site_quests' => PlayerSiteQuest::filters()->defaultSort('id', 'desc')->paginate(10)
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::table('player_site_quests', [
                TD::make('id', 'ID'),

                TD::make('player', 'Игрок')
                    ->render(function ($player_site_quest) {
                        return $player_site_quest->player->name;
                    }),

                TD::make('site_quest', 'Квест')
                    ->render(function ($player_site_quest) {
                        return $player_site_quest->site_quest->name;
                    }),

                TD::make('status', 'Статус')
                    ->filter(TD::FILTER_SELECT, [
                        PlayerSiteQuest::IN_START => 'В доработке старта',
                        PlayerSiteQuest::WAIT_WORK => 'Ожидает старта',
                        PlayerSiteQuest::IN_WORKING => 'В работе',
                        PlayerSiteQuest::WAIT_DONE => 'Ожидает награды',
                        PlayerSiteQuest::DONE => 'Выполнено',
                    ])
                    ->render(function ($player_site_quest) {
                        return match ($player_site_quest->status) {
                            PlayerSiteQuest::IN_START => 'В доработке старта',
                            PlayerSiteQuest::WAIT_WORK => 'Ожидает старта',
                            PlayerSiteQuest::IN_WORKING => 'В работе',
                            PlayerSiteQuest::WAIT_DONE => 'Ожидает награды',
                            PlayerSiteQuest::DONE => 'Выполнено',
                        };
                    }),

                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function ($player_site_quest) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Проверка'))
                                    ->icon('pencil')
                                    ->route('platform.player-site-quest', $player_site_quest->id),
                            ]);
                    }),
            ])
        ];
    }
}
