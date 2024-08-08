<?php

namespace App\Containers\PaymentSection\PaymentSystem\Services;

use Illuminate\Support\Facades\Http;

class QiwiService
{
    protected $qiwi;

    public function __construct($config = 'qiwi')
    {
        switch ($config) {
            case 'qiwi':
                $this->qiwi = config('payment.qiwi');
                break;
            case 'qiwi_comment':
                $this->qiwi = config('payment.qiwi_comment');
                break;
        }
    }

    public function createRedirectURL($dto)
    {
        $billPayments = new \Qiwi\Api\BillPayments($this->qiwi['secret_key']);
        $billId = $dto->billId;
        $fields = [
            'amount' => $dto->amount,
            'currency' => 'RUB',
            'comment' => $dto->comment,
            'expirationDateTime' => $billPayments->getLifetimeByDay(0.01),
        ];
        $response = $billPayments->createBill($billId, $fields);
        return $response['payUrl'];
    }

    public function getBalance()
    {
        try {
            $url = "https://edge.qiwi.com/funding-sources/v2/persons/" . $this->qiwi['phone_number'] . "/accounts";
            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->qiwi['api_key'],
                    'Accept' => 'application/json'
                ]
            ];
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url, $options);
            $data = json_decode($response->getBody());
            $qiwi_balance = $data->accounts[0]->balance->amount;
        } catch (\Exception $ex) {
            $qiwi_balance = null;
        }
        return $qiwi_balance;
    }

    public function getHistoryPayments($operation = "IN")
    {
        try {
            $url = "/payment-history/v2/persons/" . $this->qiwi['phone_number'] . "/payments";
            return $this->callApi($url, 'GET', [
                'rows' => 50,
                'operation' => $operation
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getTransactionInfo($transactionId, $type = "IN")
    {
        try {
            $url = "/payment-history/v2/transactions/{$transactionId}";
            return $this->callApi($url, 'GET', [
                'type' => $type
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function callApi($url, $method, $params)
    {
        $response = Http::withToken($this->qiwi['api_key'])->acceptJson()->$method('https://edge.qiwi.com' . $url, $params);
        return $response->body();
    }
}
