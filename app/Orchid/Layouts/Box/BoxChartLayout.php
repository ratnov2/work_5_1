<?php

namespace App\Orchid\Layouts\Box;

use Orchid\Screen\Layouts\Chart;

class BoxChartLayout extends Chart
{

    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'График открытий основных кейсов (текущий месяц)';

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
    protected $target = 'box_chart_data';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;

    protected $colors = [
        '#c0c522',
        '#c59622',
    ];
}
