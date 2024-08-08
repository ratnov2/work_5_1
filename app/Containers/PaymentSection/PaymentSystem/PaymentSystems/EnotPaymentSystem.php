<?php

namespace App\Containers\PaymentSection\PaymentSystem\PaymentSystems;

use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\AbstractPaymentSystem;
use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentSystemException;
use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\PaymentSection\PaymentSystem\DTO\EnotCreatRedirectUrlDTO;
use App\Containers\PaymentSection\PaymentSystem\Services\EnotService;
use Illuminate\Support\Facades\DB;

class EnotPaymentSystem extends AbstractPaymentSystem
{
    protected $payment;
    private $enot_service;

    public function __construct(EnotService $enot_service)
    {
        $this->enot_service = $enot_service;
    }

    public function makePayment()
    {
        $url = $this->createRedirectURL();

        return [
            'type' => 'redirect',
            'url' => $url,
        ];
    }

    public function handleResult($result_dto)
    {
        DB::transaction(function () use ($result_dto) {
            $this->payment = Payment::where('id', $this->payment->id)->lockForUpdate()->first();

            parent::handleResult($result_dto);

            $enot = config('payment.enot');

            $amount = number_format((float) $result_dto->amount, 2, '.', '');

            $sign_2 = md5($result_dto->merchant . ':' . $amount . ':' . $enot['extra_secret_word'] . ':' . $result_dto->merchant_id);

            if ($sign_2 != $result_dto->sign_2) die('bad sign!');

            return parent::handleSuccess();
        });

        echo "Good";
    }

    private function createRedirectURL()
    {
        try {
            $dto = app(EnotCreatRedirectUrlDTO::class)->fromArray([
                'o' => $this->payment->id,
                'oa' => $this->payment->sum,
                'p' => $this->payment->paymentable->id_in_payment_system,
            ]);

            return $this->enot_service->createRedirectURL($dto);
        } catch (\Throwable $th) {
            throw new PaymentSystemException('Ошибка создания редирект ссылки');
        }
    }
}
