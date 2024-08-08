<?php

namespace App\Containers\PaymentSection\Payment\Tasks;

use App\Containers\PaymentSection\Payment\Models\PaymentPromocode;

final class GetPaymentPromocodeByValueTask
{
    public function run($is_locked = false, $value) : PaymentPromocode | null
    {
        $query = PaymentPromocode::whereValue($value);
        if($is_locked) $query->lockForUpdate();
        return $query->first();
    }
}
