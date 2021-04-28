<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\CacheKey;
use App\Models\{
    Admission,
    Approval,
    Enquiry,
    Fees,
    Installment,
    Receipt,
    School,
    User
};
use App\Orchid\Layouts\Dashboard\ApprovalListLayout;
use App\Orchid\Layouts\School\FeesRateMetric;
use App\Orchid\Layouts\School\SchoolMetrics;
use App\Services\InstallmentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use ReflectionClass;
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

    public ?User $user = null;

    public int $day = 86400;

    public bool $is_admin = false;


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $this->user = auth()->user();
        $this->is_admin = $this->user->hasAccess('admin.user');
        if (!Session::exists('school')) {
            session(['school' => optional($this->user)->school ?? new School()]);
        }

        $data = [];

        if (!$this->is_admin) {
            $approvals = Cache::remember(
                CacheKey::for(CacheKey::APPROVALS),
                $this->day,
                fn () => Approval::with('approval.admission.student')->get()
            );

            $this->hasApprovals = $approvals->isNotEmpty();

            $data = [
                'approvals' => $approvals,
                'fees_metric' => $this->feesMetrics(),
                'school_metrics' => $this->schoolMetrics(),
            ];
        }

        return $data;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Refresh Overview')
                ->icon('refresh')
                ->canSee(!$this->is_admin)
                ->method('refreshStats'),
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

        if (!$this->is_admin) {
            $views = [
                SchoolMetrics::class,
                FeesRateMetric::class,
            ];
        }

        if ($this->user->hasAccess('receipt.delete') && $this->hasApprovals) {
            $views[] = ApprovalListLayout::class;
        }

        return [
            ...$views,
            // Layout::view('dashboard.approval'),
            // Layout::view('dashboard.fees'),
            Layout::modal('changeWorkingYear', [
                Layout::rows([
                    Select::make('workingYear')
                        ->options($valid_years)
                        ->title('Select the Academic Year'),
                ]),
            ])
                ->applyButton('Next')
                ->closeButton('Cancel'),
            // Layout::view('platform::partials.welcome'),
        ];
    }

    public function updateWorkingYear()
    {
        $d = Carbon::parse(request('workingYear'));
        working_year($d);
        $this->refreshStats();
        Toast::success("Changed academic year to {$d->format('M Y')} successfully!");
    }

    public function feesMetrics()
    {
        $fees = Cache::remember(
            CacheKey::for(CacheKey::FEES),
            $this->day,
            fn () => Fees::first([
                'playgroup_total', 'nursery_total',
                'junior_kg_total', 'senior_kg_total',
            ])
        );

        return [
            ['keyValue' => '₹ ' . optional($fees)->playgroup_total,],
            ['keyValue' => '₹ ' . optional($fees)->nursery_total,],
            ['keyValue' => '₹ ' . optional($fees)->junior_kg_total,],
            ['keyValue' => '₹ ' . optional($fees)->senior_kg_total,],
        ];
    }

    public function schoolMetrics()
    {
        $payment_due = Cache::remember(
            CacheKey::for(CacheKey::PAYMENT_DUE),
            $this->day,
            fn () => Installment::where('month', today()->month)->sum('due_amount')
        );

        $receivable = Cache::remember(
            CacheKey::for(CacheKey::RECEIVABLE),
            $this->day,
            fn () => Installment::sum('due_amount')
        );

        $deposited = Cache::remember(
            CacheKey::for(CacheKey::DEPOSITED),
            $this->day,
            fn () => Receipt::where('for', Receipt::SCHOOL_FEES)->sum('amount')
        );

        $admission_count  = Cache::remember(
            CacheKey::for(CacheKey::ADMISSION),
            $this->day,
            fn () => Admission::count('id')
        );

        $enquiry_count  = Cache::remember(
            CacheKey::for(CacheKey::ENQUIRY),
            $this->day,
            fn () => Enquiry::count('id')
        );

        $conversion_count  = Cache::remember(
            CacheKey::for(CacheKey::CONVERSION),
            $this->day,
            fn () => Enquiry::count('student_id')
        );


        return [
            ['keyValue' => '₹ ' . number_format((float) $payment_due, 0)],
            ['keyValue' => '₹ ' . number_format((float) $receivable, 0)],
            ['keyValue' => '₹ ' . number_format((float) $deposited, 0)],
            ['keyValue' => number_format((float) $enquiry_count, 0)],
            ['keyValue' => number_format((float) $conversion_count, 0)],
            ['keyValue' => number_format((float) $admission_count, 0)],
        ];
    }

    public function refreshStats()
    {
        Cache::deleteMultiple(array_map(
            fn ($x) => school()->code . '_' . $x,
            array_values((new ReflectionClass(CacheKey::class))->getConstants())
        ));
    }

    public function approveDeleteReceipt(Approval $approval)
    {
        if ($approval->approval->for === Receipt::SCHOOL_FEES) {
            (new InstallmentService)->restore(
                $approval->approval->amount,
                $approval->approval->admission_id
            );
        }

        $approval->approval->delete();
        $approval->delete();

        Toast::info('Deleted receipt successfully!');
        return redirect()->route('platform.main');
    }

    public function cancelDeleteReceipt(Approval $approval)
    {
        $approval->delete();

        Toast::info('Rejected approval!');
        return redirect()->route('platform.main');
    }
}
