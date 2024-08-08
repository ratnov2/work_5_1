<?php

namespace App\Containers\Chat\Exceptions\API;

use Exception;

class ChatException extends Exception
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
