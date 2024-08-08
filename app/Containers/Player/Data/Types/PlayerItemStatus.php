<?php

namespace App\Containers\Player\Data\Types;

enum PlayerItemStatus: string
{
    case Ready = 'ready';
    case Sell = 'selled';
    case Jackpot = 'jackpoted';
    case Upgrade = 'upgraded';
    case Trade = 'traded';
    case TradeProccess = 'trade_proccessed';
    case TradeWait = 'trade_wait';
    case Mines = 'minesed';
}
