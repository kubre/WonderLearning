<?php

namespace App\Orchid\Screens\School;


use App\Models\PerformanceReport;
use App\Orchid\Layouts\ApprovalListener;
use Carbon\Carbon;
use DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class PerformanceReportApprovalScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Monthly Performance Report Approval';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Performance report filled by teacher every month needs to be approved by center head or school owner, They are not shared with parents until they are approved.';

    public $permission = 'school.users';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save')
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
            ApprovalListener::class,
        ];
    }

    public function save(Request $request)
    {
        $request->validate([
            'divisionId' => ['bail', 'required', 'exists:divisions,id',],
            'month' => 'required',
        ]);
        DB::transaction(function () use ($request) {
            $admissions = $request->input('isApproved');
            $month = Carbon::createFromFormat('d-M-Y', $request->input('month'))->startOfMonth();
            foreach ($admissions as $id => $isApproved) {
                PerformanceReport::whereDateAt($month)
                    ->where('admission_id', $id)->update([
                        'date_at' => $month,
                        'approved_at' => $isApproved ? now() : null,
                    ]);
            }
        });
        Toast::info('Approved reports successfully!');

        return redirect()->route('reports.performance.approval');
    }

    public function asyncStudents(int $divisionId, string $month, ?bool $selectAll = false)
    {
        if ($divisionId === 0 || $month === '0') {
            return compact('divisionId', 'month');
        }

        $reports = PerformanceReport::with('admission.student.school')
            ->whereDivisionId($divisionId)
            ->whereDateAt(Carbon::createFromFormat('d-M-Y', $month)->startOfMonth())
            ->get();

        return compact('reports', 'divisionId', 'month', 'selectAll');
    }
}
