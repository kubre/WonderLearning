<?php

namespace App\Orchid\Layouts\Account;

use App\Orchid\Filters\DateRangeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class DateRangeSelectionLayout extends Selection
{
    /**
     * @var string
     */
    public $template = 'layouts.selection';

    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            DateRangeFilter::class
        ];
    }
}
