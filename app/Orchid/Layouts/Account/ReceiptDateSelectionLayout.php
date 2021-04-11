<?php

namespace App\Orchid\Layouts\Account;

use App\Orchid\Filters\ReceiptDateFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ReceiptDateSelectionLayout extends Selection
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
            ReceiptDateFilter::class,
        ];
    }
}
