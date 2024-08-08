<?php

namespace App\Containers\PaymentSection\PaymentSystem\PaymentSystems;

use App\Containers\PaymentSection\PaymentSystem\DTO\PaymentSkinsbackDTO;
use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentSystemException;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\AbstractPaymentSystem;
use App\Containers\PaymentSection\PaymentSystem\Services\SkinsbackService;
use App\Containers\PaymentSection\Payment\Models\Payment;
use Illuminate\Support\Facades\DB;

class SkinsbackSystem extends AbstractPaymentSystem
{
    protected $payment;
    private $skinsback_service;

    public function __construct(SkinsbackService $skinsback_service)
    {
        $this->skinsback_service = $skinsback_service;
    }

    public function createRedirectURL()
    {
        $dto = app(PaymentSkinsbackDTO::class);
        $dto->order_id = $this->payment->id;
        $dto->steam_id = $this->payment->player->steam_id;
        if ($this->payment->player->trade_link) {
            $trade_link = $this->payment->player->trade_link;
            $row = strpos($trade_link, "&token=");
            $token = substr($trade_link, $row + 7);
            $dto->trade_token = $token;
        } else {
            $dto->trade_token = null;
        }

        return $this->skinsback_service->createRedirectURL($dto);
    }

    public function makePayment()
    {
        $url = $this->createRedirectURL();
        return [
            'type' => 'redirect',
            'url' => $url,
        ];
    }

    public function handleResult($handle_result_dto)
    {
        DB::beginTransaction();
        try {
            $this->payment = Payment::where('id', $this->payment->id)->lockForUpdate()->first();

            parent::handleResult($handle_result_dto);

            $client_secret = config("payment.skinsback.client_secret");
            $client_id = config("payment.skinsback.client_id");
            $sign = $handle_result_dto->getSign();
            $order_id = $handle_result_dto->getOrder_id();

            $params = array(
                'shopid' => $client_id,
                'order_id' => $order_id,
                'method' => 'create'
            );
            if ($this->skinsback_service->buildSignature($params, $client_secret) !== $sign) throw new PaymentSystemException('Sign error');
            if ($handle_result_dto->getStatus() != 'success') throw new PaymentSystemException('Status is not success.');

            $this->payment->sum = $handle_result_dto->getAmount();
            $this->payment->save();

            $result = parent::handleSuccess();
            DB::commit();
            if($result) exit('200');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
