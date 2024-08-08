<?php

namespace App\Orchid\Layouts\Payment;

use App\Containers\PaymentSection\Payment\Models\Payment;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;

class PaymentListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'payments';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort(),

            TD::make('final_sum', 'Полученная сумма')
                ->sort(),

            TD::make('sum', 'Сумма')
                ->sort(),

            TD::make('player', 'Игрок')
                ->render(function (Payment $payment) {
                    return Link::make($payment->player->name)->route('platform.player.edit', $payment->player);
                }),

            // TD::make('payment_system_direction', 'Платежная система')
            //     ->render(function (Payment $payment) {
            //         return $payment->payment_system_direction->payment_system->name;
            //     }),
            // TD::make('payment_system_direction', 'Направление платежной системы')
            //     ->render(function (Payment $payment) {
            //         return $payment->payment_system_direction->name;
            //     }),
            TD::make('promocode', 'Промокод')
                ->render(function (Payment $payment) {
                    return is_null($payment->promocode) ? 'Без промокода' : Link::make($payment->promocode->value)->route('platform.payment-promocode.edit', $payment->promocode);
                }),

            TD::make('status', 'Статус')
                ->render(function (Payment $payment) {
                    switch ($payment->status) {
                        case Payment::STATUS_SUCCESS:
                            return '<span style="color: green">Оплачен</span>';
                        case Payment::STATUS_WAITING:
                            return '<span style="color: blue">Ожидание</span>';
                        case Payment::STATUS_REJECTED:
                            return '<span style="color: red">Отменен</span>';
                        case Payment::STATUS_EXPIRED:
                            return '<span style="color: red">Просрочен</span>';
                    }
                    return $payment->payment_system_direction->name;
                })->sort()->filter(
                    Select::make('status2')->options([
                        Payment::STATUS_SUCCESS => 'Успешно',
                        Payment::STATUS_WAITING => 'Ожидание',
                        Payment::STATUS_REJECTED => 'Отменено',
                        Payment::STATUS_EXPIRED => 'Просрочено',
                    ])
                ),

            TD::make('created_at', 'Создан')
                ->render(function (Payment $payment) {
                    return $payment->human_created_at;
                }),

            TD::make('updated_at', 'Обновлен')
                ->render(function (Payment $payment) {
                    return $payment->human_updated_at;
                }),

        ];
    }
}
