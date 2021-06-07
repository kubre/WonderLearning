<?php

namespace App\Orchid\Layouts\School;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class KitStockLogListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'logs';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('program'),
            TD::make('quantity'),
            TD::make('added_at', 'Added At'),
        ];
    }
}
