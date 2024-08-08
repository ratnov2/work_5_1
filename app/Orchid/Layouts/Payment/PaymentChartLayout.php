<?php

namespace App\Orchid\Layouts\Payment;

use Orchid\Screen\Layouts\Chart;

class PaymentChartLayout extends Chart
{

    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'График дохода/расхода (текущий месяц)';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'bar';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = 'payments_chart_data';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;

    protected $colors = [
        '#22c55e',
        '#c52222',
    ];
}
