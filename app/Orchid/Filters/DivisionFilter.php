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
        'month',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Divisions';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder;
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        $monthList = [];

        list($start, $end) = working_year();
        $startMonth = $start->copy();
        $endMonth = $end->copy();

        for ($i = $startMonth; $i <= $endMonth; $i->addMonth()) {
            $monthList[$i->format('y-m-d') . '|' . $i->copy()->endOfMonth()->format('y-m-d')] = $i->format('M-y');
        }

        $query = Division::when(
            !auth()->user()->hasAccess('school.users'),
            fn ($query, $isTeacher) => $query->ofTeacher(auth()->id())
        )->selectRaw("id, concat(title, ' (', program, ')') as name");

        return [
            Select::make('division')
                ->title('Division')
                ->empty('Select Division', 0)
                ->value($this->request->get('division', 0))
                ->fromQuery($query, 'name')
                ->required(),
            Select::make('month')
                ->title('Month')
                ->empty('Select Month', 0)
                ->value($this->request->get('month', 0))
                ->options($monthList)
                ->required(),
        ];
    }
}
