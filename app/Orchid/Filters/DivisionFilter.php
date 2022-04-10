<?php

namespace App\Orchid\Filters;

use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class DivisionFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'division',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Division';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->when($this->request->get('division') != 0, function ($query) {
            $query->where('division_id', $this->request->get('division'));
        });
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        $query = Division::when(
            !auth()->user()->hasAccess('school.users'),
            fn ($query) => $query->ofTeacher(auth()->id())
        )->selectRaw("id, concat(title, ' (', program, ')') as name");
        return [
            Select::make('division')
                ->title('Division')
                ->empty('All Divisions', 0)
                ->value($this->request->get('division'))
                ->fromQuery($query, 'name')
                ->required()
        ];
    }
}
