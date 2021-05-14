<?php

namespace App\Orchid\Layouts;

use App\Models\Admission;
use Illuminate\Database\Eloquent\Collection;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class AttendanceListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'division_id',
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncStudentList';

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Label::make('ignore_1')
                        ->title('Student Name'),
                    Label::make('ignore_2')
                        ->title('Present/Absent'),
                ]),
                ...$this->makeStudentList($this->query->get('admissions')),
            ]),
        ];
    }

    public function makeStudentList(?Collection $admissions): array
    {
        if (is_null($admissions)) {
            return [];
        }

        return $admissions->map(
            fn (Admission $admission) => Group::make([
                Label::make('name.' . $admission->student_id)
                    ->value($admission->student->prn),
                Label::make('name.')
                    ->value($admission->student->name),
                Switcher::make('is_present.' . $admission->student_id)
                    ->sendTrueOrFalse(),
            ]),
        )->toArray();
    }
}
