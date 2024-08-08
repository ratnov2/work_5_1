<?php

namespace App\Containers\Withdraw\Tasks;

final class GetPartnerFromTradeLinkTask
{
    public function run($trade_link)
    {
        $row = strpos($trade_link, "partner=");
        $str = substr($trade_link, $row + 8);
        $row = strpos($str, "&token=");
        $partner = substr($str, 0, $row);
        return $partner;
    }
}
