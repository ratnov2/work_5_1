<?php

namespace App\Containers\PaymentSection\Payment\Exceptions;

use Exception;

class PaymentException extends Exception
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
