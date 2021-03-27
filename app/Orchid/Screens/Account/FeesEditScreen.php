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

    /** @var array */
    const FEES_FORMAT = ['Fees' => 'fees', 'Amount' => 'amount'];

    /** @var null|Fees */
    protected $fees;

    /** @var Carbon */
    protected $working_date;

    public function __construct()
    {
        /** @todo Set to user chosen academic year */
        $this->working_date = Carbon::today();
        $this->fees = Fees::getFeesCard($this->working_date) ?? new Fees();
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $this->name .= Fees::getAcademicYearFormatted($this->working_date);
        return optional($this->fees)->toArray() ?? [];
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

    public function save(Fees $f, Request $request)
    {
        $request->validate([
            'playgroup' => 'required',
            'nursery' => 'required',
            'junior_kg' => 'required',
            'senior_kg' => 'required',
        ]);

        $many_fees = collect($request->except('_token'));
        $totals = $many_fees->mapWithKeys(fn($fees, $group) => 
            [$group.'_total' => collect($fees)->sum('amount')]);

        $this->fees->fill(array_merge(
            $totals->all(), $request->all(), 
            ['title' => Fees::getAcademicYearFormatted($this->working_date),
            'school_id' => auth()->user()->school->id,
            'created_at' => $this->working_date,],)
        )->save();
        
        Toast::info('Updated Fees Rate Card!');
    }
}
