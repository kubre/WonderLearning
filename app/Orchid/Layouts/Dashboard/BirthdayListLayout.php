<?php

namespace App\Orchid\Layouts\Dashboard;

use App\Models\Student;
use Carbon\Carbon;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BirthdayListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'birthdays';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('dob_at', 'Date')
                ->render(fn (Student $s) => $s->dob_at->format('d-M')),
            TD::make('name', 'Student Name'),
            TD::make('admission.program', 'Programme'),
            TD::make('admission.division.title', 'Division'),
        ];
    }
}
