<?php

namespace App\Orchid\Screens\Statistics;

use App\Orchid\Actions\GetCachedStatisticsAction;
use App\Orchid\Layouts\Box\BoxChartLayout;
use App\Orchid\Layouts\Payment\PaymentChartLayout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class StatisticsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Статистика';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return app(GetCachedStatisticsAction::class)->run();
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::view('orchid.statistics.index'),
            PaymentChartLayout::class,
            BoxChartLayout::class,
        ];
    }
}
