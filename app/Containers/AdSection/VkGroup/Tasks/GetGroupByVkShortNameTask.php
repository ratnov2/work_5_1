<?php

namespace App\Containers\AdSection\VkGroup\Tasks;

use App\Containers\AdSection\VkGroup\Models\VkGroup;

final class GetGroupByVkShortNameTask
{
    public function run(string $vk_short_name, $is_locked = false) : VkGroup | null
    {
        $query = VkGroup::where('vk_short_name', $vk_short_name);
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
