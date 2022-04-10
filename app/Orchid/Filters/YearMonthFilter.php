<?php

namespace App\Orchid\Filters;

use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class YearMonthFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'month',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Month';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->when($this->request->get('month') != 0, function ($query) {
            $query->whereBetween('date_at', \explode('|', $this->request->get('month')));
        });
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

        return [
            Select::make('month')
                ->title('Month')
                ->empty('Select Month', 0)
                ->value($this->request->get('month', 0))
                ->options($monthList)
                ->required(),
        ];
    }
}
