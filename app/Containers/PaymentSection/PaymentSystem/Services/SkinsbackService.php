<?php

namespace App\Containers\PaymentSection\PaymentSystem\Services;

class SkinsbackService {
    public function createRedirectURL($dto)
    {
        $client_id = config("payment.skinsback.client_id");
        $client_secret = config("payment.skinsback.client_secret");

        $params = array(
            'shopid' => $client_id,
            'order_id' => $dto->order_id,
            'method' => 'create'
        );
        $params['sign'] = $this->buildSignature($params, $client_secret);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://bill.skinsback.com/api.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $server_output = json_decode($server_output);
        if ($server_output->status == 'error') {
            throw new \Exception();
        }

        $url = $server_output->url;
        return $url;
    }

    function buildSignature($params, $secretKey) {
        ksort($params);

        $paramsString = '';
        foreach ($params as $key => $value) {
            if ($key == 'sign') {
                continue;
            }
            if (is_array($value)) {
                continue;
            }
            $paramsString .= $key . ':' . $value . ';';
        }

        $sign = hash_hmac('sha1', $paramsString, $secretKey);

        return $sign;
    }
}

