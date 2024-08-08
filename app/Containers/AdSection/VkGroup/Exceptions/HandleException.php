<?php

namespace App\Containers\AdSection\VkGroup\Exceptions;

use Exception;

class HandleException extends Exception
{
    public function report()
    {
        return;
    }

    public function render()
    {
        return redirect()->route('ad.profile.vk.groups')->with([
            'status' => 'error',
            'msg' => $this->getMessage()
        ]);
    }
}
