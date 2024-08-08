<?php

namespace App\Orchid\Screens\PaymentSystem;

use App\Containers\Payment\Models\PaymentSystem;
use App\Orchid\Layouts\Payment\PaymentListLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class PaymentSystemsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Платежные системы';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'payments_systems' => PaymentSystem::get()
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
