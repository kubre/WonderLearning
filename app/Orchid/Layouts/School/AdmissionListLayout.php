<?php

namespace App\Orchid\Layouts\School;

use App\Models\Admission;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AdmissionListLayout extends Table
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
            TD::make('admission_at', 'Admission Date')->sort()->filter(TD::FILTER_DATE),
            TD::make('student_id', 'Name')->filter(TD::FILTER_TEXT)->render(fn (Admission $a) => $a->student->name),
            TD::make('parent_name', 'Parents')
                ->filter(TD::FILTER_TEXT)
                ->render(fn (Admission $a) => join('/', array_filter([$a->student->father_name, $a->student->mother_name]))),
            TD::make('parent_contact', 'Contacts')
                ->filter(TD::FILTER_TEXT)
                ->render(fn (Admission $a) => join('/', array_filter([$a->student->father_contact, $a->student->mother_contact]))),
            TD::make('program', 'Program')->filter(TD::FILTER_TEXT),
            TD::make('fees_installments', 'Fees Installments')->filter(TD::FILTER_NUMERIC),
            TD::make('batch', 'Batch')->filter(TD::FILTER_TEXT),
            TD::make('actions', 'Actions')
                ->render(fn (Admission $s) =>
                    Link::make('Edit')->icon('note')->route('school.admission.edit', $s))
        ];
    }
}
