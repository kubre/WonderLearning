<?php

namespace App\Orchid\Screens\School;

use App\Models\Admission;
use App\Models\Receipt;
use App\Orchid\Layouts\ReceiptListLayout;
use App\View\Components\AdmissionReceipt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

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
                ->paginate();
        } else {
            $this->admission = Admission::find(request('admission_id'));
            $receipts = Receipt::filters()
                ->where('for', Receipt::SCHOOL_FEES)
                ->where('admission_id', $this->admission->id)
                ->paginate();
        }

        return [
            'receipts' => $receipts,
            'admission' => $this->admission,
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
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $views = [];
        if (!is_null($this->admission)) {
            $views[] = Layout::component(AdmissionReceipt::class);
        }
        return [
            ...$views,
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
        }

        $receipt->delete();
        Toast::info('You have successfully deleted the enquiry.');
        return redirect()->route('school.receipt.list', $data);
    }

    public function issueReceipt(int $receipt, string $option, bool $is_multi_layout): RedirectResponse
    {
        return redirect()->route('school.receipt.print', [
            'receipt' => $receipt,
            'parent' => request('for'),
            'is_multi_layout' => $is_multi_layout,
        ]);
    }
}
