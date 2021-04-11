<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;

class ReceiptDateFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'from_date',
        'to_date'
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Receipt Dates';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder
            ->whereBetween('receipt_at', [$this->request->get('from_date'), $this->request->get('to_date')]);
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            DateTimer::make('from_date')
                ->format('Y-m-d')
                ->value($this->request->get('from_date'))
                ->title('From Date'),
            DateTimer::make('to_date')
                ->format('Y-m-d')
                ->value($this->request->get('to_date'))
                ->title('To Date'),
        ];
    }
}
