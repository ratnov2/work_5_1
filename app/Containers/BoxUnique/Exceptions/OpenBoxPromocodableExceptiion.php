<?php

namespace App\Containers\BoxUnique\Exceptions;

use Exception;

class OpenBoxPromocodableExceptiion extends Exception
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
