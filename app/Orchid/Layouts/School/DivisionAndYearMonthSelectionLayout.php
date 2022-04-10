<?php

namespace App\Orchid\Layouts\School;

use App\Orchid\Filters\DivisionFilter;
use App\Orchid\Filters\YearMonthFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class DivisionAndYearMonthSelectionLayout extends Selection
{
    public $template = 'layouts.selection';

    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            DivisionFilter::class,
            YearMonthFilter::class
        ];
    }
}
