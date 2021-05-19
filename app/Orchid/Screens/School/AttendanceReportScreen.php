<?php

namespace App\Orchid\Screens\School;

use App\Models\Admission;
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

        if ($request->has('division') && $request->has('month')) {
            // TODO: maybe someday
            $sql = <<<'QUERY'
            SELECT DAY(date_at) date,
            students.id student_id, name student_name, code student_code,
                IF(absent_id = students.id, "A", "P") attendance 
                FROM division_attendances
                LEFT JOIN absents ON division_attendance_id = division_attendances.id 
                JOIN students
                WHERE division_attendances.division_id = :division_id1 
                AND date_at BETWEEN :start1 AND :end1
            EXCEPT
            SELECT DAY(date_at) date,
            students.id student_id, name student_name, code student_code,
                if(absent_id = students.id, "A", "P") attendance 
                FROM division_attendances
                LEFT JOIN absents ON division_attendance_id = division_attendances.id 
                JOIN students ON absent_id IS NOT NULL AND students.id != absent_id
                WHERE division_attendances.division_id = :division_id2
                AND date_at BETWEEN :start2 AND :end2
                GROUP BY student_id, absent_id
                ORDER BY date, student_code; 
            QUERY;

            $divisionId = $request->get('division');
            list($start, $end) = \explode('|', $request->get('month'));

            $attendances = DivisionAttendance::fromQuery($sql, [
                'division_id1' => $divisionId,
                'division_id2' => $divisionId,
                'start1' => $start,
                'start2' => $start,
                'end1' => $end,
                'end2' => $end,
            ])
                ->mapToGroups(fn ($item) => [
                    $item->student_id => $item // by student id
                ])
                ->map(fn ($item) => $item->mapWithKeys(
                    fn ($item) => [$item->date => $item] // then by date
                ));

            $admissions = Admission::whereDivisionId($divisionId)
                ->with('student.school')
                ->get();

            $date = Carbon::createFromFormat('y-m-d', $start);

            $days = days_in_month($date->month, $date->year);
        } else {
            $attendances = collect();
            $admissions = collect();
        }

        return compact('attendances', 'days', 'admissions');
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
