<?php

namespace App\Orchid\Layouts\School;

use Orchid\Screen\Layouts\Metric;

class FeesRateMetric extends Metric
{
    /**
     * @var string
     */
    protected $title = 'Fees Overview';

    /**
     * Get the labels available for the metric.
     *
     * @return array
     */
    protected $labels = [
        'Playgroup',
        'Nursery',
        'Junior KG',
        'Senior KG',
    ];

    /**
     * The name of the key to fetch it from the query.
     *
     * @var string
     */
    protected $target = 'fees_metric';
}
