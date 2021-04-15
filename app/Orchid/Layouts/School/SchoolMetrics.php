<?php

namespace App\Orchid\Layouts\School;

use Orchid\Screen\Layouts\Metric;

class SchoolMetrics extends Metric
{
    /**
     * @var string
     */
    protected $title = 'Overview';

    /**
     * Get the labels available for the metric.
     *
     * @return array
     */
    protected $labels = [
        'Payment Due (This Month)',
        'Payment Due (This Year)',
        'Deposited',
        'Total Enquiries',
        'Converted',
        'Total Admissions',
    ];

    /**
     * The name of the key to fetch it from the query.
     *
     * @var string
     */
    protected $target = 'school_metrics';
}
