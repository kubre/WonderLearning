<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Approval;
use App\Models\Fees;
use App\Models\School;
use App\Orchid\Layouts\Dashboard\ApprovalListLayout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Session;

class PlatformScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Dashboard';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Welcome!';

    public bool $hasApprovals = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        if (!Session::exists('school')) {
            session(['school' => optional(auth()->user())->school ?? new School]);
        }

        $approvals = Approval::with('approval.admission.student')->get();
        $this->hasApprovals = $approvals->isNotEmpty();

        return [
            'fees' => Fees::first(),
            'approvals' => $approvals,
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
            ModalToggle::make('Change Academic Year (' . get_academic_year_formatted(working_year()) . ')')
                ->modalTitle('Change Academic Year')
                ->icon('calendar')
                ->modal('changeWorkingYear')
                ->method('updateWorkingYear'),
            // Link::make('Website')
            //     ->href('http://orchid.software')
            //     ->icon('globe-alt'),

            // Link::make('Documentation')
            //     ->href('https://orchid.software/en/docs')
            //     ->icon('docs'),

            // Link::make('GitHub')
            //     ->href('https://github.com/orchidsoftware/platform')
            //     ->icon('social-github'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        $valid_years = collect(range(2020, date('Y')))->mapWithKeys(function ($y) {
            $d = Carbon::createFromDate($y, session('school')->start_month, 1);
            return [$d->toDateString() => get_academic_year_formatted(get_academic_year($d))];
        });

        $views = [];
        if ($this->hasApprovals) $views[] = ApprovalListLayout::class;

        return [
            ...$views,
            // Layout::view('dashboard.approval'),
            Layout::view('dashboard.fees'),
            Layout::modal('changeWorkingYear', [
                Layout::rows([
                    Select::make('workingYear')
                        ->options($valid_years)
                        ->title('Select the Academic Year'),
                ]),
            ])
                ->applyButton('Next')
                ->closeButton('Cancel')
            // Layout::view('platform::partials.welcome'),
        ];
    }

    public function updateWorkingYear()
    {
        $d = Carbon::parse(request('workingYear'));
        working_year($d);
        Toast::success("Changed academic year to {$d->format('M Y')} successfully!");
    }

    public function approveDeleteReceipt(Approval $approval)
    {
        $approval->approval->delete();
        $approval->delete();

        Toast::info('Deleted Receipt successfully!');
        return redirect()->route('platform.main');
    }

    public function cancelDeleteReceipt(Approval $approval)
    {
        $approval->delete();

        Toast::info('Rejected approval!');
        return redirect()->route('platform.main');
    }
}
