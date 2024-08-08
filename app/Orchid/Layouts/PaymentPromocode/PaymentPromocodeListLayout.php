<?php

namespace App\Orchid\Layouts\PaymentPromocode;

use App\Containers\PaymentSection\Payment\Models\PaymentPromocode;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class PaymentPromocodeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'payment_promocodes';

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

            TD::make('value', 'Промокод')
                ->sort(),

            TD::make('precent', 'Процент')
                ->sort()
                ->render(function(PaymentPromocode $payment_promocode) {
                    return $payment_promocode->precent . ' %';
                }),

            TD::make('created_at', 'Создан')
                ->render(function (PaymentPromocode $payment_promocode) {
                    return $payment_promocode->human_created_at;
                }),

            TD::make('updated_at', 'Обновлен')
                ->render(function (PaymentPromocode $payment_promocode) {
                    return $payment_promocode->human_updated_at;
                }),

            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (PaymentPromocode $payment_promocode) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Редактировать'))
                                ->icon('pencil')
                                ->route('platform.payment-promocode.edit', $payment_promocode),

                            Button::make(__('Удалить'))
                                ->icon('trash')
                                ->confirm('Удалить этот промокод?')
                                ->method('remove', [
                                    'id' => $payment_promocode->id,
                                ]),
                        ]);
                }),

        ];
    }
}
