<?php

namespace App\Containers\Jackpot\Data\Types;

enum Status : string {
    case Wait = 'wait';
    case WaitTimeout = 'wait_timeout';
    case Active = 'active';
    case End = 'end';
}
