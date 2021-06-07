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
    Student,
    Syllabus,
    User
};
use App\Orchid\Layouts\Dashboard\ApprovalListLayout;
use App\Orchid\Layouts\Dashboard\BirthdayListLayout;
use App\Orchid\Layouts\School\FeesRateMetric;
use App\Services\ApprovalService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use ReflectionClass;

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

    public bool $isAdmin = false;

    protected ?array $admissionMetrics = null;

    protected ?array $accountMetrics = null;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $this->user = auth()->user();
        $this->isAdmin = $this->user->hasAccess('admin.user');

        $data = [];
        // School owner
        if ($this->user->hasAccess('school.users')) {
            $data['fees_metric'] = $this->feesMetrics();
            $this->admissionMetrics = $this->admissionMetrics();
            $this->accountMetrics = $this->accountMetrics();
        }

        // School owner and Center Head
        if ($this->user->hasAccess('school.approvals')) {
            $approvals = Approval::query()
                ->when(
                    $this->user->hasAccess('receipt.delete'),
                    fn ($query) => $query->orWhere('approval_type', Receipt::class)
                )
                ->when(
                    $this->user->hasAccess('school.users'),
                    fn ($query) => $query->orWhere('approval_type', Syllabus::class)
                )
                ->with(['approval' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        Receipt::class => ['admission.student'],
                    ]);
                }])->get();
            $this->hasApprovals = $approvals->isNotEmpty();
            $data['approvals'] = $approvals;
        }


        if ($this->user->hasAccess('school.year')) {
            $data['birthdays'] = Cache::remember(
                CacheKey::for(CacheKey::BIRTHDAYS),
                $this->day,
                fn () => Student::with(['admission.division'])
                    ->whereSchoolId(school()->id)
                    ->whereRaw(
                        "DATE_FORMAT(dob_at, '%m-%d') IN (?, ?)",
                        [Carbon::today()->format('m-d'), Carbon::tomorrow()->format('m-d')]
                    )
                    ->orderByRaw("DATE_FORMAT(dob_at, '%d-%m')")
                    ->get()
            );
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
                ->canSee(!$this->isAdmin)
                ->method('refreshStats'),
            ModalToggle::make('Change Academic Year (' . get_academic_year_formatted(working_year()) . ')')
                ->modalTitle('Change Academic Year')
                ->icon('calendar')
                ->canSee($this->user->hasAccess('school.year'))
                ->modal('changeWorkingYear')
                ->method('updateWorkingYear'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        $views = [
            Layout::view('layouts.reset'),
        ];

        if ($this->user->hasAccess('school.users')) {
            $views[] = Layout::stats('Admissions Overview', $this->admissionMetrics);
            $views[] = Layout::stats('Accounts Overview', $this->accountMetrics);
            $views[] = FeesRateMetric::class;
        }

        if ($this->user->hasAccess('school.approvals') && $this->hasApprovals) {
            $views[] = Layout::view('components.title', ['title' => 'Approvals']);
            $views[] = ApprovalListLayout::class;
        }

        if ($this->user->hasAccess('school.year')) {
            $views[] = Layout::view('components.title', ['title' => '🎂 Upcoming Birthdays']);
            $views[] = BirthdayListLayout::class;

            $validYears = collect(range(2020, date('Y') + 1))->mapWithKeys(function ($y) {
                $d = Carbon::createFromDate($y, school()->start_month, 1);
                return [$d->toDateString() => get_academic_year_formatted(get_academic_year($d))];
            });

            $views[] = Layout::modal('changeWorkingYear', [
                Layout::rows([
                    Select::make('workingYear')
                        ->options($validYears)
                        ->title('Select the Academic Year'),
                ]),
            ])
                ->applyButton('Next')
                ->closeButton('Cancel');
        }

        return $views;
    }

    public function updateWorkingYear()
    {
        $date = Carbon::parse(request('workingYear'));
        working_year($date);
        $this->refreshStats();
        Toast::success("Changed academic year to {$date->format('M Y')} successfully!");
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

    public function admissionMetrics()
    {
        $admissionCount = Cache::remember(
            CacheKey::for(CacheKey::ADMISSION),
            $this->day,
            fn () => Admission::count('id')
        );

        $enquiryCount  = Cache::remember(
            CacheKey::for(CacheKey::ENQUIRY),
            $this->day,
            fn () => Enquiry::count('id')
        );

        return [
            [
                'title' => 'Enquiries',
                'value' => number_format((float) $enquiryCount, 0),
                'link' => route('school.enquiry.list'),
            ],
            [
                'title' => 'Gross Admissions',
                'value' => number_format((float) $admissionCount, 0),
                'link' => route('school.admission.list'),
            ],
        ];
    }

    public function accountMetrics()
    {
        $collectionDue = Cache::remember(
            CacheKey::for(CacheKey::PAYMENT_DUE),
            $this->day,
            fn () => Installment::sum('due_amount')
        );

        $receivable = Cache::remember(
            CacheKey::for(CacheKey::RECEIVABLE),
            $this->day,
            fn () => Installment::sum('amount')
        );

        $collection = Cache::remember(
            CacheKey::for(CacheKey::DEPOSITED),
            $this->day,
            fn () => Receipt::where('for', Receipt::SCHOOL_FEES)->sum('amount')
        );

        return [
            [
                'title' => 'Gross Receivable',
                'value' => '₹ ' . number_format((float) $receivable, 0),
            ],
            [
                'title' => 'Collection',
                'value' => '₹ ' . number_format((float) $collection, 0),
            ],
            [
                'title' => 'Collection Due',
                'value' => '₹ ' . number_format((float) $collectionDue, 0)
            ],
        ];
    }

    public function refreshStats()
    {
        Cache::deleteMultiple(array_map(
            fn ($x) => school()->code . '_' . $x,
            array_values((new ReflectionClass(CacheKey::class))->getConstants())
        ));
    }

    public function approve(Approval $approval)
    {
        (new ApprovalService())->handle($approval);
        Toast::info('Approved the action successfully!');
        return redirect()->route('platform.main');
    }

    public function cancel(Approval $approval)
    {
        (new ApprovalService())->cancel($approval);
        Toast::info('Rejected approval!');
        return redirect()->route('platform.main');
    }
}
