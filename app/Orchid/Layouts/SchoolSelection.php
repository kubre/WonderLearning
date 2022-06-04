<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\SchoolFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class SchoolSelection extends Selection
{
    public $template = 'layouts.selection';

    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            SchoolFilter::class
        ];
    }
}
