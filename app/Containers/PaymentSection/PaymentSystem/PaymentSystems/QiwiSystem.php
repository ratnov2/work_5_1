<?php

namespace App\Containers\PaymentSection\PaymentSystem\PaymentSystems;

use App\Containers\PaymentSection\PaymentSystem\DTO\PaymentQiwiDTO;
use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentSystemException;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\AbstractPaymentSystem;
use App\Containers\PaymentSection\PaymentSystem\Services\QiwiService;
use App\Containers\PaymentSection\Payment\Models\Payment;
use Illuminate\Support\Facades\DB;

class QiwiSystem extends AbstractPaymentSystem
{
    protected $payment;
    private $qiwi_service;

    public function __construct()
    {
        $this->qiwi_service = new QiwiService(config:'qiwi');
    }

    public function createRedirectURL()
    {
        try {
            $dto = app(PaymentQiwiDTO::class);
            $dto->billId = $this->payment->id;
            $dto->amount = $this->payment->sum;
            $dto->comment = 'Invoice №' . $this->payment->id;
            return $this->qiwi_service->createRedirectURL($dto);
        } catch (\Throwable $th) {
            throw new PaymentSystemException('Ошибка создания редирект ссылки');
        }
    }

    public function makePayment()
    {
        return [
            'type' => 'redirect',
            'url' => $this->createRedirectURL()
        ];
    }

    public function handleResult($handle_result_dto = null)
    {
        DB::beginTransaction();
        try {
            $this->payment = Payment::where('id', $this->payment->id)->lockForUpdate()->first();
            parent::handleResult($handle_result_dto);
            parent::handleSuccess();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
