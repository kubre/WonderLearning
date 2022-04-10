<?php

namespace App\Orchid\Layouts\Teacher;

use App\Models\Admission;
use App\Models\Fees;
use App\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class PerformanceReportFillingListLayout extends Table
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
        $this->user = auth()->user();
        return [
            TD::make('prn', 'PRN')
                ->render(fn (Admission $a) => $a->student->prn),
            TD::make('student_name', 'Name')
                ->render(fn (Admission $a) => $a->student->name)
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('program', 'Programme'),
            TD::make('division.title', 'Division'),
            TD::make('batch', 'Batch'),
            TD::make('actions', 'Actions')
                ->render(
                    fn (Admission $a) =>
                        ModalToggle::make('Fill')
                        ->icon('pencil')
                        ->type(Color::PRIMARY())
                        ->modal('preparePerformanceReport')
                        ->modalTitle('Fill details')
                        ->method('prepareReport')
                        ->canSee($this->user->hasAccess('teacher.subjects'))
                        ->asyncParameters($a->id)
            ),
        ];
    }
}
