<?php

namespace App\Containers\Withdraw\Tasks;

final class GetTokenFromTradeLinkTask
{
    public function run($trade_link)
    {
        $row = strpos($trade_link, "&token=");
        $token = substr($trade_link, $row + 7);
        return $token;
    }
}
