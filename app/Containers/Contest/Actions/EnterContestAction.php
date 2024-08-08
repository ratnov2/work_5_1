<?php

namespace App\Containers\Contest\Actions;

use App\Containers\Condition\Actions\ValidateConditionAction;
use App\Containers\Contest\Data\Types\Status;
use App\Containers\Contest\Events\UpdatedContestCountPlayersEvent;
use App\Containers\Contest\Exceptions\ContestException;
use App\Containers\Contest\Tasks\GetContestByIdTask;
use App\Containers\Player\Tasks\GetAuthPlayerTask;

final class EnterContestAction
{
    public function run($contest_id)
    {
        $contest = app(GetContestByIdTask::class)->run($contest_id);

        if(!$contest) throw new ContestException('Розыгрыш не найден');
        if($contest->status != Status::Active) throw new ContestException('Данный розыгрыш не является активным');
        if(\Carbon\Carbon::parse($contest->end_at) < \Carbon\Carbon::now()) throw new ContestException('Данный конкурс уже завершен и ждет обработки');

        $player = app(GetAuthPlayerTask::class)->run();
        if($player->contests()->where('contests.id', $contest->id)->exists()) throw new ContestException('Вы уже принимали участие в этом розыгрыше');

        app(ValidateConditionAction::class)->run($player, $contest->condition);

        $player->contests()->attach($contest);

        event(new UpdatedContestCountPlayersEvent($contest));
    }
}
