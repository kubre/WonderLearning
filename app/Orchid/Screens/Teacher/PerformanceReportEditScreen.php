<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Admission;
use App\Models\PerformanceReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\RadioButtons;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PerformanceReportEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Performance Report for ';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Individual student\'s performance report form filling.';

    public $permission = 'teacher.student';

    public array $template;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Admission $admission, string $month): array
    {
        $report = $admission
            ->reports()
            ->whereDateAt(Carbon::createFromFormat('d-M-Y', $month)->startOfMonth())
            ->firstOrNew();
        $this->template = $report->performance;
        $this->name .= $admission->student->name . ': ' .  substr($month, 3);
        return compact('admission', 'report');
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
            ...$this->buildForm($this->template),
            Layout::rows([
                Button::make('Save')
                    ->icon('save')
                    ->type(Color::PRIMARY())
                    ->method('save'),
            ]),
        ];
    }

    public function buildForm(array $template): array
    {
        return collect($template)
            ->map(
                fn ($criterion, $title) =>
                Layout::rows($this->buildCriterion($criterion, $title))
                    ->title($title)
            )->values()->toArray();
    }

    public function buildCriterion(array $criterion, string $title): array
    {
        return collect($criterion)
            ->map(
                fn ($value, $criteria) => Group::make([
                    TextArea::make($criteria)
                        ->readonly()
                        ->class('form-control-plaintext label')
                        ->value($criteria),
                    Input::make($criteria)
                        ->clear()
                        ->hidden()
                        ->class('w-0')
                        ->value($title),
                    RadioButtons::make($criteria)
                        ->value($value)
                        ->options([
                            'Needs Encouragement' => 'Needs Encouragement',
                            'Sometimes' => 'Sometimes',
                            'Always' => 'Always',
                        ]),
                ])
            )
            ->toArray();
    }

    public function save(Admission $admission, string $month, Request $request)
    {
        $performance = collect($request->except('_token'))
            ->mapToGroups(fn ($input) => [$input[1] => [$input[0], $input[2]]])
            ->map(fn ($skill) => $skill->mapWithKeys(fn ($item) => [$item[0] => $item[1]]))
            ->toJson();
        $t1 = collect($request->except('_token'));
        $t2 = $t1->mapToGroups(fn ($input) => [$input[1] => [$input[0], $input[2]]]);
        $t3 = $t2->map(fn ($skill) => $skill->mapWithKeys(fn ($item) => [$item[0] => $item[1]]));
        
        dd($t1, $t2, $t3);

        $dateAt = Carbon::createFromFormat('d-M-Y', $month)->startOfMonth();

        PerformanceReport::updateOrInsert([
            'admission_id' => $admission->id,
            'date_at' => $dateAt,
        ], [
            'admission_id' => $admission->id,
            'date_at' => $dateAt,
            'performance' => $performance,
            'division_id' => $admission->division_id,
        ]);

        Toast::info('Saved performance observations successfully!');

        return redirect()->route('teacher.students.list');
    }
}
