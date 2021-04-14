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


    public const MONTHS = [
        '1' => 'Jan',
        '2' => 'Feb',
        '3' => 'Mar',
        '4' => 'Apr',
        '5' => 'May',
        '6' => 'Jun',
        '7' => 'Jul',
        '8' => 'Aug',
        '9' => 'Sep',
        '10' => 'Oct',
        '11' => 'Nov',
        '12' => 'Dec',
    ];

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
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
                    ->options(static::MONTHS),
                Input::make('amount.')
                    ->type('number')
                    ->required()
                    ->title("$i) Amount")
            ]);
        }
        return $installments;
    }
}
