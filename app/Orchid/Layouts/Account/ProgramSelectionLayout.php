<?php

namespace App\Orchid\Layouts\Account;

use App\Orchid\Filters\ProgramFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ProgramSelectionLayout extends Selection
{
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
