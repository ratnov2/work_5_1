<?php

namespace App\Orchid\Screens\PaymentSystem;

use App\Containers\PaymentSection\Payment\Models\PaymentPromocode;
use App\Orchid\Layouts\PaymentPromocode\PaymentPromocodeListLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class PaymentPromocodeListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Промокоды к депозиту';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = '';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'payment_promocodes' => PaymentPromocode::filters()->defaultSort('id', 'desc')->paginate(10)
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Создать новый промокод')
                ->icon('pencil')
                ->route('platform.payment-promocode.edit'),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            PaymentPromocodeListLayout::class
        ];
    }

      /**
     * @param Request $request
     */
    public function remove(Request $request)
    {
        PaymentPromocode::findOrFail($request->get('id'))
            ->delete();

        Toast::info('Промокод удален');

        return redirect()->route('platform.payment-promocode.list');
    }
}
