<?php

namespace App\Containers\BoxUnique\Tasks;

use App\Containers\BoxUnique\Models\Box;

final class GetPromocodableBoxTask
{
    public function run() : Box
    {
        return Box::promocodable()->first();
    }
}
