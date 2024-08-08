<?php

namespace App\Orchid\Helpers\Condition;

class GetConditionParams
{
    public function run($condition_params)
    {
        foreach ($condition_params['action'] as $key => $type) {
            if(count($type) == 1 && isset($type['name'])) unset($condition_params['action'][$key]);
        }

        $condition_params['action'] = count($condition_params['action']) == 0 ? null : json_encode($condition_params['action']);

        return $condition_params;
    }
}
