<?php

namespace App\Orchid\Screens\School;

use App\Models\Admission;
use App\Models\Approval;
use App\Models\Receipt;
use App\Orchid\Layouts\ReceiptListLayout;
use App\Services\InstallmentService;
use App\View\Components\AdmissionReceipt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Str;

class ReceiptListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Receipts';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Manage Receipts';

    public const OPTION_PRINT = 0;

    public const OPTION_EMAIL = 1;

    public ?Admission $admission = null;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        if (is_null(request('admission_id'))) {
            $receipts = Receipt::filters()
                ->where('for', '!=', Receipt::SCHOOL_FEES)
                ->with('admission.student')
                ->simplePaginate(100);
        } else {
            $this->admission = Admission::find(request('admission_id'));
            $receipts = Receipt::filters()
                ->where('for', Receipt::SCHOOL_FEES)
                ->where('admission_id', $this->admission->id)
                ->simplePaginate(100);
        }

        return [
            'receipts' => $receipts,
            'admission' => $this->admission,
            'installments' => optional($this->admission)->installments,
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
            Link::make('Add Receipt')
                ->icon('plus')
                ->type(Color::PRIMARY())
                ->canSee(is_null($this->admission) || $this->admission->balance_amount > 0)
                ->route('school.receipt.edit', [
                    'admission_id' => optional($this->admission)->id,
                    'for' => is_null($this->admission) ? null : Receipt::SCHOOL_FEES,
                ]),

            Link::make('Export to Excel')
                ->icon('table')
                ->class('btn export-csv ml-5')
                ->type(Color::SUCCESS())
                ->href('javascript:exportCsv()')
                ->rawClick(true),

            Link::make('Print/Export PDF')
                ->icon('printer')
                ->type(Color::WARNING())
                ->href('javascript:printTable()'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        // Used to redirect back from receipt edit screen to Admissions page on correct index
        $hasLastAdmissionPage = Str::contains(url()->previous(), '/admin/admissions');
        if ($hasLastAdmissionPage) {
            session(['last_page_from_receipt' => url()->previous()]);
        } else {
            session()->forget('last_page_from_receipt');
        }

        $views = [];
        if (!is_null($this->admission)) {
            $views['School Fees Details'] = Layout::component(AdmissionReceipt::class);
            $views['Installments'] = Layout::view('components.installments');
        }
        return [
            Layout::tabs($views),
            ReceiptListLayout::class,
            Layout::modal('chooseReceiptReceiversName', [
                Layout::rows([
                    Select::make('for')
                        ->options([
                            'father' => 'Father\'s Name',
                            'mother' => 'Mother\'s Name',
                        ])->title('Generate receipt on'),
                ]),
            ])
                ->applyButton('Next')
                ->closeButton('Cancel'),
        ];
    }

    public function cancel(Receipt $receipt)
    {
        $data = [];
        if ($receipt->for === Receipt::SCHOOL_FEES) {
            $data['admission_id'] = $receipt->admission_id;

            (new InstallmentService())->restore(
                $receipt->amount,
                $receipt->admission_id
            );
        }

        $receipt->delete();
        Toast::info('You have successfully deleted the receipt.');
        return redirect()->route('school.receipt.list', $data);
    }

    public function requestDelete(Receipt $receipt)
    {
        $receipt->approval()->save(new Approval([
            'school_id' => $receipt->school_id,
            'method' => 'deleteReceipt',
            'created_at' => working_year()[0],
        ]));

        Toast::info('Requested school owner for deletion of receipt!');

        if ($receipt->for === Receipt::SCHOOL_FEES) {
            return redirect()->route(
                'school.receipt.list',
                ['admission_id' => $receipt->admission_id]
            );
        }

        return redirect()->route('school.receipt.list');
    }

    public function issueReceipt(
        int $receipt,
        string $option,
        bool $isMultiLayout
    ): RedirectResponse {
        return redirect()->route('school.receipt.print', [
            'receipt' => $receipt,
            'parent' => request('for'),
            'is_multi_layout' => $isMultiLayout,
        ]);
    }
}
