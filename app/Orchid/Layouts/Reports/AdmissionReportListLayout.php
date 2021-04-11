<?php

namespace App\Orchid\Layouts\Reports;

use App\Models\Admission;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AdmissionReportListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'admissions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('student.state', 'State'),
            TD::make('student.city', 'City'),
            TD::make('program', 'Program'),
            TD::make('batch', 'Batch'),
            TD::make('invoice_no', 'Invoice No'),
            TD::make('admission_at', 'Admission Date'),
            TD::make('student.name', 'Name'),
            // TD::make('admission_status', 'Admission Status')
            //     ->render(fn (Admission $a) => $a->created_at-> ),
            TD::make('student.prn', 'PRN'),
            TD::make('student.father_name', 'Father\'s Name'),
            TD::make('student.father_occupation', 'Father\'s Occupation'),
            TD::make('student.father_contact', 'Father\'s Contact'),
            TD::make('student.father_email', 'Father\'s Email'),
            TD::make('student.mother_name', 'Mother\'s Name'),
            TD::make('student.mother_occupation', 'Mother\'s Occupation'),
            TD::make('student.mother_contact', 'Mother\'s Contact'),
            TD::make('student.mother_email', 'Mother\'s Email'),
            TD::make('student.dob_at', 'Date Of Birth')
                ->render(fn (Admission $a) => $a->student->dob_at->format('d-M-y')),
            TD::make('student.gender', 'Gender'),
            TD::make('created_at', 'Admission Date')
                ->render(fn (Admission $a) => $a->created_at->format('d-M-y')),
            TD::make('student.address', 'Address'),
            TD::make('transport', 'Transport')
                ->render(fn (Admission $a) => $a->is_transportation_required ? 'Yes' : 'No'),
            TD::make('admission_at', 'Date Of Conversion')
                ->render(fn (Admission $a) => $a->admission_at->format('d-M-y')),
            TD::make('student.previous_school', 'Previous Schooling'),
        ];
    }

    /**
     * Usage for zebra-striping to any table row.
     *
     * @return bool
     */
    protected function striped(): bool
    {
        return true;
    }

    /**
     * Usage for borders on all sides of the table and cells.
     *
     * @return bool
     */
    protected function bordered(): bool
    {
        return true;
    }
}
