<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class BatchFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'batch',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Batch';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        if ($this->request->get('batch') === 'All') return $builder;
        return $builder->where('batch', $this->request->get('batch'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make('batch')
                ->value($this->request->get('batch'))
                ->options([
                    'All' => 'All',
                    'Morning' => 'Morning',
                    'Afternoon' => 'Afternoon',
                ]),
        ];
    }
}
