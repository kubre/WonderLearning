<?php

namespace App\Orchid\Screens\School;

use App\Models\DivisionAttendance;
use App\Orchid\Layouts\School\DivisionSelectionLayout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class AttendanceReportScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Monthly Attendance Report';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Monthly attendance report by division';

    public $permission = 'menu.report';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): array
    {
        $days = days_in_month(1, 2000);
        $classes = collect();

        if ($request->get('division') != 0 && $request->get('month') != 0) {
            $period = \explode('|', $request->get('month'));

            $classes = DivisionAttendance::with('attendances.admission.student.school')
                ->whereBetween('date_at', $period)
                ->whereDivisionId($request->get('division'))
                ->orderBy('date_at')
                ->get();

            $date = Carbon::createFromFormat('y-m-d', $period[0]);
            $days = days_in_month($date->month, $date->year);

            $classes =
                $classes
                ->mapWithKeys(
                    fn ($item) => [
                        $item->date_at =>
                        $item->attendances
                            ->mapWithKeys(fn ($aItem) => [
                                $aItem->admission_id => [
                                    'id' => $aItem->admission_id,
                                    'name' => $aItem->admission->student->name,
                                    'prn' => $aItem->admission->student->prn,
                                    'date' => $item->date_at,
                                    'status' => $aItem->status,
                                ]
                            ])
                    ]
                )
                ->collapse()
                ->groupBy('id')
                ->mapWithKeys(fn ($item, $key) => [
                    $key => $item->mapWithKeys(
                        fn ($aItem) => [
                            (int)\substr($aItem['date'], 0, 2)  => $aItem['status'],
                            'name' => $aItem['name'],
                            'prn' => $aItem['prn'],
                            'date' => $aItem['date'],
                        ]
                    ),
                ]);
        }

        return compact('classes', 'days');
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
            DivisionSelectionLayout::class,
            Layout::view('reports.attendance'),
        ];
    }
}
