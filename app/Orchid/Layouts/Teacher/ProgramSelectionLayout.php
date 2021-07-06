<?php

namespace App\Orchid\Layouts\Teacher;

use App\Orchid\Filters\ProgramFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ProgramSelectionLayout extends Selection
{
    public $template = 'layouts.selection';

    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            ProgramFilter::class,
        ];
    }
}
