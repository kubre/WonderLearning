<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ProgramFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'program'
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Programme';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('program', $this->request->get('program'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make('program')
                ->value($this->request->get('program'))
                ->options([
                    'Playgroup' => 'Playgroup',
                    'Nursery' => 'Nursery',
                    'Junior KG' => 'Junior KG',
                    'Senior KG' => 'Senior KG',
                ])
                ->title('Programme'),
        ];
    }
}
