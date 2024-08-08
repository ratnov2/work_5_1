<?php

namespace App\Containers\Withdraw\UI\API\Exceptions;

use Exception;

class ItemWithdrawException extends Exception
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
