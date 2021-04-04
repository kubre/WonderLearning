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

    public ?Admission $admission;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $this->admission = Admission::findOrFail(request('admission_id'));
        if (!is_null($this->admission)) {
            $receipts = Receipt::where('admission_id', $this->admission->id)->paginate();
        } else {
            $receipts = Receipt::paginate();
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
                ->canSee(($this->admission->total_fees - $this->admission->paid_fees) > 0)
                ->route('school.receipt.edit', ['admission_id' => $this->admission->id]),
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
            Layout::component(AdmissionReceipt::class),
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

    public function issueReceipt(int $receipt, string $option): RedirectResponse
    {
        return redirect()->route('school.receipt.print', [
            'receipt' => $receipt,
            'parent' => request('for'),
        ]);
    }
}
