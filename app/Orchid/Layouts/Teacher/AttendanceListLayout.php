<?php

namespace App\Orchid\Layouts\Teacher;

use App\Models\DivisionAttendance;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AttendanceListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'division_attendances';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('division.title_and_program', 'Division'),
            TD::make('date_at', 'Date'),
            TD::make('absents_count', 'Total Absent students'),
        ];
    }
}
