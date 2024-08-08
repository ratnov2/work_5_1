<?php

namespace App\Orchid\Screens\PlayerSiteQuest;

use App\Containers\SiteQuest\Models\PlayerSiteQuest;
use App\Containers\Player\Tasks\GetPlayerByIdTask;
use App\Containers\SiteQuest\Models\PlayerSiteQuestReward;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PlayerSiteQuestScreen extends Screen
{
    protected $player_site_quest;
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Проверка';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(PlayerSiteQuest $player_site_quest): array
    {
        $this->player_site_quest = $player_site_quest;

        $this->name = match ($player_site_quest->status) {
            PlayerSiteQuest::IN_START => 'В доработке старта',
            PlayerSiteQuest::WAIT_WORK => 'Ожидает старта',
            PlayerSiteQuest::IN_WORKING => 'В работе',
            PlayerSiteQuest::WAIT_DONE => 'Ожидает награды',
            PlayerSiteQuest::DONE => 'Выполнено',
        };

        return [
            'player_site_quest' => $player_site_quest
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [  
            Button::make('На доработку')
                ->method('rejectWaitWork')
                ->canSee($this->player_site_quest->status == PlayerSiteQuest::WAIT_WORK),

            Button::make('На доработку')
                ->method('rejectWaitDone')
                ->canSee($this->player_site_quest->status == PlayerSiteQuest::WAIT_DONE),
                
            Button::make('Подтвердить')
                ->method('acceptWorkWait')
                ->canSee($this->player_site_quest->status == PlayerSiteQuest::WAIT_WORK),
                
            Button::make('Выдать награду')
                ->confirm(__('Точно выдать награду?'))
                ->method('acceptWorkDone')
                ->canSee($this->player_site_quest->status == PlayerSiteQuest::WAIT_DONE),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('comment')
                    ->type('text')
                    ->title('При отправке на доработку, укажите комментарий для пользователя'),
            ])->canSee(in_array($this->player_site_quest->status, [PlayerSiteQuest::WAIT_WORK, PlayerSiteQuest::WAIT_DONE])),

            Layout::view('orchid.playerSiteQuest.index'),
        ];
    }

    public function rejectWaitWork(PlayerSiteQuest $player_site_quest, Request $request)
    {
        $comment = $request->get('comment');

        if(is_null($comment)) {
            Toast::error('Пожалуйста, укажите комментарий для пользоваателя');
            return;
        };

        $player_site_quest->fill([
            'wait_work_comment' => $comment,
            'status' => PlayerSiteQuest::IN_START,
        ])->save();

        Alert::info('Успешно');

        return redirect()->route('platform.player-site-quest.list');
    }

    public function rejectWaitDone(PlayerSiteQuest $player_site_quest, Request $request)
    {
        $comment = $request->get('comment');

        if(is_null($comment)) {
            Toast::error('Пожалуйста, укажите комментарий для пользоваателя');
            return;
        };
        
        $player_site_quest->fill([
            'wait_done_comment' => $comment,
            'status' => PlayerSiteQuest::IN_WORKING,
        ])->save();

        Alert::info('Успешно');

        return redirect()->route('platform.player-site-quest.list');
    }

    public function acceptWorkWait(PlayerSiteQuest $player_site_quest, Request $request)
    {
        $player_site_quest->status = PlayerSiteQuest::IN_WORKING;
        $player_site_quest->save();

        Alert::info('Успешно');

        return redirect()->route('platform.player-site-quest.list');
    }

    public function acceptWorkDone(PlayerSiteQuest $player_site_quest, Request $request)
    {
        DB::transaction(function () use($player_site_quest) {
            $player = app(GetPlayerByIdTask::class)->run($player_site_quest->player->id, true);
            
            $player_site_quest->fill(['status' => PlayerSiteQuest::DONE])->save();
            PlayerSiteQuestReward::create(['player_site_quest_id' => $player_site_quest->id, 'value' => $player_site_quest->site_quest->reward_price]);

            $player->balance += $player_site_quest->site_quest->reward_price;
            $player->save();
        });

        Alert::info('Успешно');

        return redirect()->route('platform.player-site-quest.list');
    }
}
