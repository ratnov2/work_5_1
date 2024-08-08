<?php

namespace App\Containers\Trade\Data\Types;

enum Status : string {
    case Success = 'success';
    case Fail = 'fail';
    case Wait = 'wait';
    case Proccessing = 'proccessing';
    case ProccessingFail = 'proccessing_fail';
}
