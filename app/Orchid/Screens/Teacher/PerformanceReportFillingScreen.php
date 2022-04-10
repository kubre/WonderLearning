<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Admission;
use App\Orchid\Layouts\School\DivisionSelectionLayout;
use App\Orchid\Layouts\Teacher\PerformanceReportFillingListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PerformanceReportFillingScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Performance Report Filling';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Performance Report Filling for students.';

    public $permission = 'teacher.subjects';

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
                ->filtersApplySelection(DivisionSelectionLayout::class)
                ->whereIn('division_id', $divisions)
                ->with(['student.school', 'division'])
                ->simplePaginate(30),
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
            DivisionSelectionLayout::class,
            PerformanceReportFillingListLayout::class,
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
