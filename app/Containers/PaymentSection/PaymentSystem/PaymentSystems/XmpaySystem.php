<?php

namespace App\Containers\PaymentSection\PaymentSystem\PaymentSystems;

use App\Containers\PaymentSection\PaymentSystem\DTO\PaymentXmpayDTO;
use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentSystemException;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\AbstractPaymentSystem;
use App\Containers\PaymentSection\PaymentSystem\Services\XmpayService;
use App\Containers\PaymentSection\Payment\Models\Payment;
use Illuminate\Support\Facades\DB;

class XmpaySystem extends AbstractPaymentSystem
{
    protected $payment;
    private $xmpay_service;

    public function __construct(XmpayService $xmpay_service)
    {
        $this->xmpay_service = $xmpay_service;
    }

    public function createRedirectURL()
    {
        try {
            $dto = app(PaymentXmpayDTO::class)->fromArray([
                'label' => $this->payment->id,
                'amount' => $this->payment->sum,
            ]);
            return $this->xmpay_service->createRedirectURL($dto);
        } catch (\Throwable $th) {
            throw new PaymentSystemException('Ошибка создания редирект ссылки');
        }
    }

    public function makePayment()
    {
        $url = $this->createRedirectURL();
        return [
            'type' => 'redirect',
            'url' => $url
        ];
    }

    public function handleResult($handle_result_dto)
    {
        DB::beginTransaction();
        try {
            $this->payment = Payment::where('id', $this->payment->id)->lockForUpdate()->first();

            parent::handleResult($handle_result_dto);

            $xmpay = config('payment.xmpay');
            $params = $handle_result_dto->toArray();
            $hash = hash('sha256', $params['shop_id'] . $params['amount'] . $xmpay['secret_key'] . $params['id']); // генерируем hash на вашей стороне
            if ($hash != $params['hash']) throw new PaymentSystemException('NO HASH');

            $result = parent::handleSuccess();
            DB::commit();
            if($result) exit('200');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
