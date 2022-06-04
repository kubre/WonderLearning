<?php

namespace App\Orchid\Filters;

use App\Models\School;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class SchoolFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'school'
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'School';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereHas('school', function ($query) {
            return $query->where('id', $this->request->get('school'));
        });
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        $query = School::selectRaw("id, name");
        return [
            Select::make('school')
                ->title('School')
                ->empty('All Schools', 0)
                ->value($this->request->get('school'))
                ->fromQuery($query, 'name')
                ->required()
        ];
    }
}
