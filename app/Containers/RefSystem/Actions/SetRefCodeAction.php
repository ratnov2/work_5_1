<?php

namespace App\Containers\RefSystem\Actions;

use App\Containers\Player\Exceptions\API\ProfileException;
use App\Containers\Player\Models\Player;
use App\Containers\Player\Tasks\GetAuthPlayerTask;

final class SetRefCodeAction
{
    public function run($ref_code)
    {
        $ref_code = trim($ref_code);

        $player = app(GetAuthPlayerTask::class)->run();

        if (Player::where([['id', '!=', $player->id], ['ref_code', $ref_code]])->exists()) throw new ProfileException('Данный реф. код уже используется');

        Player::where('id', $player->id)->update(['ref_code' => $ref_code]);

        return true;
    }
}
