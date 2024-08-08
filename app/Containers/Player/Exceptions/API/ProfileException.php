<?php

namespace App\Containers\Player\Exceptions\API;

use Exception;

class ProfileException extends Exception
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
