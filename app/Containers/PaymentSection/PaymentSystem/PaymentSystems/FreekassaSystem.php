<?php

namespace App\Containers\PaymentSection\PaymentSystem\PaymentSystems;

use App\Containers\PaymentSection\PaymentSystem\DTO\PaymentFreekassaDTO;
use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentException;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\AbstractPaymentSystem;
use App\Containers\PaymentSection\PaymentSystem\Services\FreekassaService;
use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentSystemException;
use App\Containers\PaymentSection\Payment\Models\Payment;
use Illuminate\Support\Facades\DB;

class FreekassaSystem extends AbstractPaymentSystem
{
    protected $payment;
    private $freekassa_service;

    public function __construct(FreekassaService $freekassa_service)
    {
        $this->freekassa_service = $freekassa_service;
    }

    public function createRedirectURL()
    {
        try {
            $dto = app(PaymentFreekassaDTO::class)->fromArray([
                'order_id' => $this->payment->id,
                'order_amount' => $this->payment->sum,
                'i' => $this->payment->payment_system_direction->id_in_payment_system,
            ]);
            return $this->freekassa_service->createRedirectURL($dto);
        } catch (\Throwable $th) {
            throw new PaymentSystemException('Ошибка создания редирект ссылки');
        }
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
        return DB::transaction(function() use ($handle_result_dto) {
            $this->payment = Payment::where('id', $this->payment->id)->lockForUpdate()->first();

            parent::handleResult($handle_result_dto);

            $freekassa = config('payment.freekassa');
            $params = $handle_result_dto->toArray();
            if (md5($freekassa['merchant_id'] . ':' . $params['AMOUNT'] . ':' . $freekassa['secret_word_2'] . ':' . $params['MERCHANT_ORDER_ID']) != $params['SIGN']) throw new PaymentException('wrong sign');

            $result = parent::handleSuccess();
            if($result) die('YES');
        });
    }
}
