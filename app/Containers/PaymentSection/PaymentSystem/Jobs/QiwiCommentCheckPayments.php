<?php

namespace App\Containers\PaymentSection\PaymentSystem\Jobs;

use App\Containers\Payment\DTO\ResultQiwiCommentDTO;
use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\Payment\PaymentSystems\PaymentSystemManager;
use App\Containers\Payment\Services\QiwiService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QiwiCommentCheckPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $qiwi_service = new QiwiService(config:'qiwi_comment');
            $qiwi_payments = json_decode($qiwi_service->getHistoryPayments(), true)['data'];

            foreach ($qiwi_payments as $qiwi_payment) {
                if(
                    $qiwi_payment['status'] != 'SUCCESS' ||
                    !isset($qiwi_payment['sum']['amount']) ||
                    !isset($qiwi_payment['sum']['currency']) ||
                    $qiwi_payment['sum']['currency'] != 643 ||
                    is_null($qiwi_payment['comment'])
                ) {
                    continue;
                }

                try {
                    $dto = app(ResultQiwiCommentDTO::class)->fromArray($qiwi_payment);
                    if(!$payment = Payment::firstWhere('id', $dto->getComment())) continue;
                    $payment_system_manager = new PaymentSystemManager();
                    $payment_system_manager->selectPayment($payment)->handleResult($dto);
                } catch (\Throwable $th) {}
            }
        } catch (\Throwable $th) {
            $this->fail($th);
        }
    }
}
