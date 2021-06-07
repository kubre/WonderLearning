<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Admission;
use App\Models\Division;
use App\Models\DivisionAttendance;
use App\Orchid\Layouts\AttendanceListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class AttendanceEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Record Attendance';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Record attendance for specific division and date';

    public $permission = 'teacher.subjects';

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
            Layout::rows([
                Group::make([
                    Select::make('division_id')
                        ->title('Division')
                        ->empty('Select Division', 0)
                        ->required()
                        ->fromQuery(
                            Division::ofTeacher(auth()->id())
                                ->selectRaw("id, concat(title, ' (', program, ')') as name"),
                            'name'
                        ),
                    DateTimer::make('date_at')
                        ->title('Date')
                        ->required(),
                ]),
            ]),
            AttendanceListener::class,
        ];
    }


    public function save(Request $request)
    {
        $request->validate(
            [
                'division_id' => ['bail', 'required', 'exists:divisions,id'],
                'date_at' => ['bail', 'required', 'date', Rule::unique('division_attendances')
                    ->where(function ($query) use ($request) {
                        return $query->where('division_id', $request->division_id)
                            ->where('date_at', $request->date_at);
                    })],
            ],
            [
                'division_id' => 'Divisions is required and must exist!',
                'date_at.unique' => 'Attendance on the same date for same division has already been taken!',
            ]
        );

        $attendances = collect($request->is_present)
            ->map(fn ($item, $key) => [
                'admission_id' => $key,
                'is_present' => $item,
            ]);

        DB::transaction(function () use ($request, $attendances) {
            DivisionAttendance::create($request->only('division_id', 'date_at'))
                ->attendances()
                ->createMany($attendances);
        });

        return redirect()->route('teacher.attendance.list');
    }

    public function asyncStudentList(int $divisionId): array
    {
        return [
            'admissions' => Admission::with('student.school')
                ->whereDivisionId($divisionId)
                ->get(),
        ];
    }
}
