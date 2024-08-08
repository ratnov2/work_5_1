<?php

namespace App\Containers\PaymentSection\PaymentSystem\Services;

use App\Containers\PaymentSection\PaymentSystem\DTO\EnotCreatRedirectUrlDTO;

class EnotService
{
    public function createRedirectURL(EnotCreatRedirectUrlDTO $dto)
    {
        $enot = config('payment.enot');

        $sign = md5($enot['merchant_id'] . ':' . $dto->oa . ':' . $enot['secret_word'] . ':' . $dto->o);

        $params = [
            'm' => $enot['merchant_id'],
            'oa' => $dto->oa,
            'o' => $dto->o,
            's' => $sign,
            'cr' => $dto->cr,
        ];
        if (!is_null($dto->p)) $params['p'] = $dto->p;

        switch ($dto->p) {
            case 'qw':
                $url = 'https://oplata.to/pay?';
                break;

            default:
                $url = 'https://enot.io/pay?';
                break;
        }

        return $url . http_build_query($params);
    }
}
