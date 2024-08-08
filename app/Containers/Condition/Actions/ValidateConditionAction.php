<?php

namespace App\Containers\Condition\Actions;

use App\Containers\Condition\Exceptions\ConditionException;
use App\Containers\Condition\Models\Condition;
use App\Containers\Condition\SubActions\ValidateTelegramPlatformSubAction;
use App\Containers\Condition\SubActions\ValidateVKPlatformSubAction;
use App\Containers\Player\Models\Player;

final class ValidateConditionAction
{
    public function run(Player $player, Condition|null $condition) : void
    {
        if(is_null($condition)) return;

        $action = !is_null($condition->action) ? json_decode($condition->action, true) : null;

        if(!is_null($action)) {
            foreach ($action as $platform_name => $platform) {
                if($platform_name == 'any') continue;
                $validator = $this->factoryPlatformValidator($platform_name);
                $validator->run($player, $platform);
            }
        }
    }

    private function factoryPlatformValidator($platform_name)
    {
        switch ($platform_name) {
            case 'vk':
                return app(ValidateVKPlatformSubAction::class);

            case 'telegram':
                return app(ValidateTelegramPlatformSubAction::class);

            default:
                throw new ConditionException('Ошибка проверки условий');
        }
    }
}
