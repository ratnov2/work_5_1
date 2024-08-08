<?php

namespace App\Orchid\Screens\PaymentSystem;

use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Orchid\Layouts\Payment\PaymentListLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class PaymentListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Пополнения';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все пополнения';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'payments' => Payment::filters()->defaultSort('id', 'desc')->paginate(10)
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
            PaymentListLayout::class
        ];
    }
}
