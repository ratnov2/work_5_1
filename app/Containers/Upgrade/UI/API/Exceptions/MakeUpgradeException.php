<?php

namespace App\Containers\Upgrade\UI\API\Exceptions;

use Exception;

class MakeUpgradeException extends Exception
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
