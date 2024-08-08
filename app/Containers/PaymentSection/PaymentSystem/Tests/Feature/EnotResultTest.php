<?php

namespace app\Containers\PaymentSection\PaymentSystem\Tests\Feature;

use App\Containers\PaymentSection\Payment\DTO\CreatePaymentDTO;
use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\PaymentSection\Payment\Tasks\CreatePaymentTask;
use App\Containers\PaymentSection\PaymentSystem\Models\PaymentSystemDirection;
use App\Containers\Player\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnotResultTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_enot_payment_result()
    {
        // Prepare payment
        $player = Player::factory()->zeroBalance()->create();

        $payment_system_direction = PaymentSystemDirection::find(1);

        $create_payment_dto = app(CreatePaymentDTO::class)->fromArray([
            'sum' => 10.00,
            'player_id' => $player->id,
            'paymentable_type' => $payment_system_direction::class,
            'paymentable_id' => $payment_system_direction->id,
            'status' => Payment::STATUS_WAITING,
        ]);
        $payment = app(CreatePaymentTask::class)->run($create_payment_dto);

        $enot = config('payment.enot');
        $amount = number_format((float) $payment->sum, 2, '.', '');
        $sign = md5($enot['merchant_id'] . ':' . $amount . ':' . $enot['secret_word'] . ':' . $payment->id);
        $sign_2 = md5($enot['merchant_id'] . ':' . $amount . ':' . $enot['extra_secret_word'] . ':' . $payment->id);

        $response = $this->withoutExceptionHandling()->post('/api/payment/enot/result', [
            'merchant' => $enot['merchant_id'],
            'merchant_id' => $payment->id,
            'amount' => $payment->sum,
            'sign' => $sign,
            'sign_2' => $sign_2,
            'currency' => 'RUB',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'sum' => $payment->sum,
            'player_id' => $player->id,
            'status' => Payment::STATUS_SUCCESS,
        ]);

        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'balance' => $payment->sum,
        ]);
    }
}
