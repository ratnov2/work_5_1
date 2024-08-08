<?php

namespace App\Containers\SiteQuest\Exceptions\API;

use Exception;

class SiteQuestException extends Exception
{
    public function report()
    {
        return;
    }

    public function render()
    {
        return response()->json([
            'status' => 'error',
            'msg' => $this->getMessage()
        ]);
    }
}
