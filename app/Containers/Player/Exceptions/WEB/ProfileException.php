<?php

namespace App\Containers\Player\Exceptions\WEB;

use Exception;

class ProfileException extends Exception
{
    public function report()
    {
        return;
    }

    public function render()
    {
        return redirect()->to('/')->withFragment('#/profile')->with([
            'status' => 'error',
            'msg' => $this->getMessage()
        ]);
    }
}
