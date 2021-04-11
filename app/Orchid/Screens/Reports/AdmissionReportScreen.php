<?php

namespace App\Orchid\Screens\Reports;

use App\Models\Admission;
use App\Orchid\Layouts\Account\ProgramSelectionLayout;
use App\Orchid\Layouts\Reports\AdmissionReportListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class AdmissionReportScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Admissions Report';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Admissions Report';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'admissions' => Admission::with(['student.school'])
                ->filtersApplySelection(ProgramSelectionLayout::class)
                ->get(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Export to Excel')
                ->icon('table')
                ->class('btn export-csv')
                ->type(Color::SUCCESS())
                ->href('javascript:exportCsv()')
                ->rawClick(true),
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
            ProgramSelectionLayout::class,
            AdmissionReportListLayout::class,
        ];
    }
}
