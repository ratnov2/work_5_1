<?php

namespace App\Containers\Site\Tasks;

use App\Containers\Site\Models\SiteCategory;

final class GetActiveSiteCategoriesTask
{
    public function run()
    {
        return SiteCategory::active()->orderBy('position')->get();
    }
}
