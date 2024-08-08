<?php

namespace App\Containers\PaymentSection\PaymentSystem\Services;

class FreekassaService {

    public static function getBalance()
    {
        try {
            $merchant_id = config('payment.freekassa.merchant_id');
            $api_key = config('payment.freekassa.secret_word');

            $params = ['shopId' => $merchant_id, 'nonce' => time()];
            ksort($params);
            $sign = hash_hmac('sha256', implode('|', $params), $api_key);
            $params['signature'] = $sign;
            $request = json_encode($params);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.freekassa.ru/v1/balance');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FAILONERROR, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            $result = trim(curl_exec($ch));
            curl_close($ch);

            $response = json_decode($result, true);
            $freekassa_balance = $response['balance'];
        } catch (\Exception $ex) {
            $freekassa_balance = null;
        }

        return $freekassa_balance;
    }

    public function createRedirectURL($dto)
    {
        $merchant_id = config('payment.freekassa.merchant_id');
        $secret_word = config('payment.freekassa.secret_word');

        $sign = md5($merchant_id.':'.$dto->order_amount.':'.$secret_word.':'.$dto->currency.':'.$dto->order_id);
        $params = [
            'm' => $merchant_id,
            'oa' => $dto->order_amount,
            'currency' => $dto->currency,
            'o' => $dto->order_id,
            's' => $sign,
            'lang' => app()->getLocale()
        ];
        if(!is_null($dto->i)) $params['i'] = $dto->i;
        $url = 'https://pay.freekassa.ru/?' . http_build_query($params) ;
        return $url;
    }

    public function getIP() {
        if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
        return $_SERVER['REMOTE_ADDR'];
    }
}
