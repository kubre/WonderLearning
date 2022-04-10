<?php

namespace App\Orchid\Layouts;

use App\Models\Division;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Color;

class ApprovalListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'divisionId',
        'month',
        'selectAll',
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
    protected $asyncMethod = 'asyncStudents';

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Select::make('divisionId')
                        ->title('Division')
                        ->empty('Select Division', 0)
                        ->value($this->query->get('divisionId', 0))
                        ->fromQuery(Division::selectRaw("id, concat(title, ' (', program, ')') as name"), 'name')
                        ->required(),
                    Select::make('month')
                        ->title('Month')
                        ->empty('Select Month', 0)
                        ->value($this->query->get('month'))
                        ->options(get_months(working_year()))
                        ->required(),
                ]),
                Switcher::make('selectAll')
                    ->title('Approve All')
                    ->horizontal()
                    ->help('Checking this will approve all the students reports for selected month')
                    ->checked($this->query->get('selectAll', false))
                    ->sendTrueOrFalse(),
            ]),
            Layout::rows([
                Group::make([
                    Label::make('')
                        ->title('Student'),
                    Label::make('')
                        ->title('Approval (Check to approve)'),
                    Label::make('')
                        ->title(''),
                    Label::make('Actions (Click to view the report)')
                        ->title('Actions'),
                ]),
                ...$this->buildApprovals($this->query->get('reports'))
            ])
                ->canSee(!is_null($this->query->get('reports'))),
        ];
    }

    public function buildApprovals($reports = null)
    {
        if (is_null($reports)) {
            return [];
        }

        $month = $this->query->get('month');

        return $reports->map(
            fn ($report) => Group::make([
                Label::make('label.' . $report->admission->id)
                    ->value($report->admission->student->name . ' (' . $report->admission->student->prn . ')'),
                Switcher::make('isApproved.' . $report->admission->id)
                    ->sendTrueOrFalse()
                    ->checked(!is_null($report->approved_at) || $this->query->get('selectAll')),
                Input::make('admissionId.' . $report->admission->id)
                    ->hidden()
                    ->value($report->admission_id),
                Link::make('ViewReport')
                    ->icon('bar-chart')
                    ->type(Color::PRIMARY())
                    ->href(route('reports.performance.fill', [
                        'admissionId' => $report->admission_id,
                        'month' => $month,
                    ]))
            ])
        )->toArray();
    }
}
