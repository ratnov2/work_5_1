<?php

namespace App\Containers\PaymentSection\PaymentSystem\Jobs;

use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\Payment\PaymentSystems\PaymentSystemManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class QiwiCheckPayments implements ShouldQueue
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
            $qiwi = config('payment.qiwi');
            $billPayments = new \Qiwi\Api\BillPayments($qiwi['secret_key']);

            $payments = Payment::qiwi()->waiting()->get();
            foreach ($payments as $payment) {
                try {
                    $response = $billPayments->getBillInfo($payment->id);
                    $status = $response['status']['value'];
                    switch ($status) {
                        case 'PAID':
                            $payment_system_manager = new PaymentSystemManager($payment->payment_system_direction->payment_system->slug);
                            $payment_system_manager->selectPayment($payment)->handleResult();
                            break;
                        case 'WAITING':
                            $payment->status = Payment::STATUS_WAITING;
                            $payment->save();
                            break;
                        case 'REJECTED':
                            $payment->status = Payment::STATUS_REJECTED;
                            $payment->save();
                            break;
                        case 'EXPIRED':
                            $payment->status = Payment::STATUS_EXPIRED;
                            $payment->save();
                            break;
                    }
                } catch (\Throwable $th) {
                    Log::build([
                        'driver' => 'single',
                        'path' => storage_path('logs/payment/qiwi/job-result/error.log'),
                    ])->info($th);
                }
            }
        } catch (\Exception $ex) {
            $this->fail($ex);
        }
    }
}
