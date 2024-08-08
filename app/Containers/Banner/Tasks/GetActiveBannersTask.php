<?php

namespace App\Containers\Banner\Tasks;

use App\Containers\Banner\Models\Banner;

final class GetActiveBannersTask
{
    public function run()
    {
        return Banner::active()->get();
    }
}
