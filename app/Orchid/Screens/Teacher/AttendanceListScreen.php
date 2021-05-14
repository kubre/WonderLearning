<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\DivisionAttendance;
use App\Orchid\Layouts\Teacher\AttendanceListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class AttendanceListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Attendance';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = '';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'division_attendances' => DivisionAttendance::with('division')
                ->withCount('absents')
                ->simplePaginate(),
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
            Link::make('Add Attendance')
                ->icon('plus')
                ->route('teacher.attendance.create')
                ->type(Color::PRIMARY()),
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
            AttendanceListLayout::class,
        ];
    }
}
