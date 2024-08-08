<?php

namespace App\Containers\PaymentSection\PaymentSystem\PaymentSystems;

use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentSystemException;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\AbstractPaymentSystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class QiwiCommentSystem extends AbstractPaymentSystem
{
    protected $payment;

    public function makePayment()
    {
        $qiwi = config('payment.qiwi_comment');
        $params = [
            'phone_number' => $qiwi['phone_number'],
            'sum' => $this->payment->sum,
            'comment' => $this->payment->id,
        ];
        $info_html = View::make('paymentsection.paymentsystem::qiwi-comment-info')->with($params)->render();
        return [
            'type' => 'no_redirect',
            'info_html' => $info_html
        ];
    }

    public function handleResult($handle_result_dto)
    {
        DB::beginTransaction();
        try {
            if (ceil($this->payment->sum) != ceil($handle_result_dto->getSum()['amount'])) throw new PaymentSystemException('Incorrect amount');
            parent::handleResult($handle_result_dto);
            parent::handleSuccess();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
