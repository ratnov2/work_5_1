<?php

namespace App\Containers\PaymentSection\PaymentSystem\Actions;

use App\Containers\PaymentSection\Payment\DTO\CreatePaymentDTO;
use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\PaymentSection\Payment\Tasks\CreatePaymentTask;
use App\Containers\PaymentSection\Payment\Tasks\GetPaymentPromocodeByValueTask;

use App\Containers\PaymentSection\PaymentSystem\DTO\MakePaymentDTO;
use App\Containers\PaymentSection\PaymentSystem\Exceptions\API\PaymentSystemException;
use App\Containers\PaymentSection\PaymentSystem\Models\PaymentSystemDirection;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\PaymentSystemManager;

final class MakePaymentAction
{
    public function run(MakePaymentDTO $make_payment_dto)
    {
        $payment_system_direction_id = $make_payment_dto->getPayment_system_direction_id();
        $payment_system_direction = PaymentSystemDirection::findOrFail($payment_system_direction_id);
        $payment_system_manager = new PaymentSystemManager($payment_system_direction->payment_system->slug);

        $create_payment_params = [
            'sum' => $make_payment_dto->getSum(),
            'player_id' => $make_payment_dto->getPlayer_id(),
            'paymentable_type' => PaymentSystemDirection::class,
            'paymentable_id' => $payment_system_direction->id,
            'status' => Payment::STATUS_WAITING,
        ];

        $promocode_value = $make_payment_dto->getPromocode_value();
        if (!is_null($promocode_value)) {
            $promocode = app(GetPaymentPromocodeByValueTask::class)->run(false, $promocode_value);
            if (!$promocode) throw new PaymentSystemException('Промокод не найден');
            $create_payment_params['promocode_id'] = $promocode->id;
        }

        $create_payment_dto = app(CreatePaymentDTO::class)->fromArray($create_payment_params);
        $payment = app(CreatePaymentTask::class)->run($create_payment_dto);

        $payment_system_manager->selectPayment($payment);
        return $payment_system_manager->makePayment();
    }
}
