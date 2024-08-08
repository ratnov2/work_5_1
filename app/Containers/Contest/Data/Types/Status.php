<?php

namespace App\Containers\Contest\Data\Types;

enum Status : string {
    case Wait = 'wait';
    case Active = 'active';
    case Finish = 'finish';
}
