<?php

namespace App\Orchid\Screens\Account;

use App\Models\Fees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class FeesEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Fees Rate Card for ';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Edit Current Year\'s Fees Rate Card';


    /** @var array|string */
    public $permission = 'fees.edit';

    const FEES_FORMAT = ['Fees' => 'fees', 'Amount' => 'amount'];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $this->name .= get_academic_year_formatted(working_year());
        return optional(Fees::first())->toArray() ?? [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save Changes')
                ->icon('save')
                ->type(Color::PRIMARY())
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Matrix::make('playgroup')
                        ->title('Playgroup Fees')
                        ->columns(self::FEES_FORMAT)
                        ->fields([
                            'amount' => Input::make()->type('number'),
                        ]),
                    Matrix::make('nursery')
                        ->title('Nursery Fees')
                        ->columns(self::FEES_FORMAT)
                        ->fields([
                            'amount' => Input::make()->type('number'),
                        ]),
                ]),
                Group::make([
                    Matrix::make('junior_kg')
                        ->title('Junior KG Fees')
                        ->columns(self::FEES_FORMAT)
                        ->fields([
                            'amount' => Input::make()->type('number'),
                        ]),
                    Matrix::make('senior_kg')
                        ->title('Senior KG Fees')
                        ->columns(self::FEES_FORMAT)
                        ->fields([
                            'amount' => Input::make()->type('number'),
                        ]),
                ]),
            ]),
        ];
    }

    public function save(Request $request)
    {
        $request->validate([
            'playgroup' => 'required_without_all:nursery,junior_kg,senior_kg',
            'nursery' => 'required_without_all:playgroup,junior_kg,senior_kg',
            'junior_kg' => 'required_without_all:nursery,playgroup,senior_kg',
            'senior_kg' => 'required_without_all:nursery,junior_kg,playgroup',
        ]);

        $fees = Fees::first() ?? new Fees;
        $working_year = working_year();

        $many_fees = collect($request->except('_token'));
        $totals = $many_fees->mapWithKeys(fn ($fees, $group) =>
        [$group . '_total' => collect($fees)->sum('amount')]);

        $fees->fill(
            array_merge(
                $totals->all(),
                $request->all(),
                [
                    'title' => get_academic_year_formatted($working_year),
                    'school_id' => auth()->user()->school_id,
                    'created_at' => $working_year[0],
                ],
            )
        )->save();

        Toast::info('Updated Fees Rate Card!');
    }
}
