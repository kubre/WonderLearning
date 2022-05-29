<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;

class InstallmentListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'installment_count',
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncInstallmentCount';

    public array $monthList = [];

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        $monthList = [];

        list($start, $end) = working_year();
        $startMonth = $start->copy()->subMonths(12);
        $endMonth = $end->copy();
        // \dd($startMonth->format('d M Y'), $endMonth->format('d M Y'));

        for ($i = $startMonth; $i <= $endMonth; $i->addMonth()) {
            $monthList[$i->format('n Y')] = $i->format('M Y');
        }

        $this->monthList = $monthList;
        return [
            Layout::rows(
                $this->makeInstallments($this->query->get('installment_count') ?? 1),
            )
        ];
    }

    public function makeInstallments($installment_count): array
    {
        $installments = [];
        for ($i = 1; $i <= $installment_count; $i++) {
            $installments[] = Group::make([
                Select::make('month.')
                    ->title("$i) Month")
                    ->required()
                    ->options($this->monthList),
                Input::make('amount.')
                    ->type('number')
                    ->required()
                    ->title("$i) Amount")
            ]);
        }
        return $installments;
    }
}
