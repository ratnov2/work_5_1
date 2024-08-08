<?php

namespace App\Containers\PaymentSection\PaymentSystem\Services;

class XmpayService {

    public function createRedirectURL($dto)
    {
        $xmpay = config('payment.xmpay');
        $secret = $xmpay['public_key'];
        $shop_id = $xmpay['shop_id'];
        $amount = $dto->getAmount();
        $label = $dto->getLabel();

        $hash = hash('sha256', $shop_id . $amount . $secret . $label);
        $link = "https://xmpay.one/merchant?shop_id=" . $shop_id . "&amount=" . $amount . "&label=" . $label . "&hash=" . $hash . "";
        return $link;
    }
}
