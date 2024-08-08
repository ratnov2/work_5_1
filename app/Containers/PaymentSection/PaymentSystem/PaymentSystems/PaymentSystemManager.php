<?php

namespace App\Containers\PaymentSection\PaymentSystem\PaymentSystems;

use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentSystemException;
use App\Containers\PaymentSection\PaymentSystem\Interfaces\PaymentSystemInterface;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\QiwiCommentSystem;
use App\Containers\PaymentSection\Payment\Models\Payment;

class PaymentSystemManager implements PaymentSystemInterface {
    protected $payment_system_instance;

    public function selectPayment(Payment $payment) : self
    {
        $this->payment_system_instance = $this->getInstancePaymentSystemBySlug($payment->paymentable->payment_system->slug);
        $this->payment_system_instance->selectPayment($payment);
        return $this;
    }

    public function makePayment()
    {
        return $this->payment_system_instance->makePayment();
    }

    public function handleResult($dto = null)
    {
        return $this->payment_system_instance->handleResult($dto);
    }

    private function getInstancePaymentSystemBySlug($payment_system_slug)
    {
        switch ($payment_system_slug) {
            case 'qiwi_comment':
                return app(QiwiCommentSystem::class);

            case 'enot':
                return app(EnotPaymentSystem::class);

            default:
                throw new PaymentSystemException('Payment system not found!');
        }
    }
}
