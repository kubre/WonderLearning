<?php

namespace App\Orchid\Layouts\School;

use App\Models\Admission;
use App\Models\Fees;
use App\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
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

    protected User $user;

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        $f = $this->query->get('fees');
        $this->user = auth()->user();
        return [
            TD::make('prn', 'PRN')
                ->render(fn (Admission $a) => $a->student->prn),
            TD::make('admission_at', 'Admission Date')
                ->render(fn (Admission $a) => $a->admission_at->format('d-M-Y'))
                ->sort()
                ->filter(TD::FILTER_DATE),
            TD::make('student_name', 'Name')
                ->render(fn (Admission $a) => $a->student->name)
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('parent_name', 'Parents')
                ->filter(TD::FILTER_TEXT)
                ->render(fn (Admission $a) =>
                join('/', array_filter([$a->student->father_name, $a->student->mother_name]))),
            TD::make('parent_contact', 'Contacts')
                ->filter(TD::FILTER_TEXT)
                ->render(fn (Admission $a) =>
                join('/', array_filter([$a->student->father_contact, $a->student->mother_contact]))),
            TD::make('program', 'Programme'),
            TD::make('division.title', 'Division'),
            TD::make('total_fees', 'Total Fees')
                ->render(fn (Admission $a) => $f->{$a->fees_total_column} - $a->discount),
            TD::make('batch', 'Batch'),
            TD::make('actions', 'Actions')
                ->render(
                    fn (Admission $a) =>
                    DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Receipt')
                                ->icon('money')
                                ->canSee($this->user->hasAccess('school.users'))
                                ->route('school.receipt.list', ['admission_id' => $a->id]),
                            ModalToggle::make('Assign Division')
                                ->icon('layers')
                                ->modal('asyncAssignDivision')
                                ->modalTitle('Assign division to a student')
                                ->method('assignDivision')
                                ->parameters(['admission' => $a->id])
                                ->canSee($this->user->hasAccess('school.users'))
                                ->asyncParameters(['admission' => $a->id, 'program' => $a->program]),
                            Button::make('Assign Kit')
                                ->icon('book-open')
                                ->method('assignKit')
                                ->confirm('Once assigned a kit cannot be reassigned back and will deduct 1 count from kits available for this programme, Are you sure?')
                                ->parameters(['admission' => $a->id])
                                ->canSee(!$a->assigned_kit && $this->user->hasAccess('school.users')),
                            Button::make('Reset Father\'s Login')
                                ->icon('lock-open')
                                ->method('resetLogin')
                                ->parameters(['student' => $a->student_id, 'parent' => 'father']),
                            Button::make('Reset Mother\'s Login')
                                ->icon('lock-open')
                                ->method('resetLogin')
                                ->parameters(['student' => $a->student_id, 'parent' => 'mother']),
                            Link::make('Graduate To')
                                ->icon('action-redo')
                                ->canSee($a->program !== 'Senior KG' && $this->user->hasAccess('school.users'))
                                ->route('school.graduation.edit', [
                                    'admission' => $a->id,
                                ]),
                            ModalToggle::make('Invoice')
                                ->icon('doc')
                                ->modal('chooseInvoiceReceiversName')
                                ->modalTitle('Print Invoice')
                                ->method('issueInvoice')
                                ->canSee($this->user->hasAccess('school.users'))
                                ->asyncParameters(['admission_id' => $a->id]),
                            ModalToggle::make('Performance Report')
                                ->icon('bar-chart')
                                ->modal('preparePerformanceReport')
                                ->modalTitle('Fill details')
                                ->method('prepareReport')
                                ->canSee($this->user->hasAccess('teacher.student'))
                                ->asyncParameters(['admission_id' => $a->id]),
                            Link::make('Edit')
                                ->icon('note')
                                ->canSee($this->user->hasAccess('admission.edit'))
                                ->route('school.admission.edit', $a->id),
                            Link::make('Declaration Form')
                                ->icon('eye')
                                ->canSee($this->user->hasAccess('school.users'))
                                ->route('reports.declaration.form', $a->id),
                            ModalToggle::make('Delete')
                                ->icon('trash')
                                ->canSee($this->user->hasAccess('admission.edit'))
                                ->modal('deleteAdmissionModal')
                                ->modalTitle('Delete Admission')
                                ->method('deleteAdmission')
                                ->parameters(['admission_id' => $a->id]),
                        ]),
                )
        ];
    }
}
