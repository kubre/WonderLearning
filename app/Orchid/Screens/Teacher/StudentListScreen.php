<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Admission;
use App\Models\Fees;
use App\Orchid\Layouts\Account\ProgramSelectionLayout;
use App\Orchid\Layouts\School\AdmissionListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class StudentListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Students';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'See all the students assigned under you across all divisions and programmes.';

    public $permission = 'teacher.student';

    public array $monthList = [];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $this->monthList = get_months(working_year());
        $divisions = auth()->user()->divisions->pluck('id')->toArray();
        return [
            'admissions' => Admission::query()
                ->filters()
                ->filtersApplySelection(ProgramSelectionLayout::class)
                ->whereIn('division_id', $divisions)
                ->with(['student.school', 'division'])
                ->simplePaginate(30),
            'fees' => Fees::first(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::modal('preparePerformanceReport', [
                Layout::rows([
                    Select::make('month')
                        ->options($this->monthList)
                        ->title('Select Month'),
                ]),
            ])
                ->applyButton('Continue')
                ->closeButton('Cancel'),
            ProgramSelectionLayout::class,
            AdmissionListLayout::class,
        ];
    }

    public function prepareReport(int $admissionId): RedirectResponse
    {
        return redirect()->route('reports.performance.fill', [
            'admissionId' => $admissionId,
            'month' => request('month'),
        ]);
    }
}
