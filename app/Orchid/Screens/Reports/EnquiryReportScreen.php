<?php

namespace App\Orchid\Screens\Reports;

use App\Models\Enquiry;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class EnquiryReportScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Enquiry Report';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Enquiry Report';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $enquiries_db = Enquiry::selectRaw('program, count(*) as total, count(*) - count(student_id) as not_converted, count(student_id) as converted')->groupBy('program')->get();

        $enquiries = [
            'Playgroup' => [],
            'Nursery' => [],
            'Junior_KG' => [],
            'Senior_KG' => [],
        ];


        foreach ($enquiries_db as $enquiry) {
            $enquiries[str_replace(' ', '_', $enquiry->program)] = $enquiry;
        }

        return $enquiries;
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

            Link::make('Print/Export PDF')
                ->icon('printer')
                ->type(Color::WARNING())
                ->href('javascript:window.print()'),
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
            Layout::view('reports.enquiry')
        ];
    }
}
