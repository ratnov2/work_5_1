<?php

namespace App\Containers\Jackpot\Exceptions\API;

use Exception;

class JackpotException extends Exception
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
