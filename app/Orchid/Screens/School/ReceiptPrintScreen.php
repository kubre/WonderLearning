<?php

namespace App\Orchid\Screens\School;

use App\Models\Receipt;
use Illuminate\Support\Facades\App;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class ReceiptPrintScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Receipt';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Export the receipt';

    public int $receiptId;

    public string $parent;

    public int $admission_id;

    public string $fileName = 'receipt_';

    public bool $is_multi_layout = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(int $receiptId, string $parent): array
    {
        $this->receiptId = $receiptId;
        $this->parent = $parent;

        $receipt = Receipt::with('admission.student.school')->findOrFail($receiptId);
        $this->admission_id = $receipt->admission_id;
        $this->fileName .= $receipt->admission->student->name . '_' . $receipt->receipt_no;
        $this->is_multi_layout = request('is_multi_layout', false);
        return compact('receipt', 'parent');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Back')
                ->icon('arrow-left')
                ->canSee($this->is_multi_layout)
                ->route('school.receipt.list'),
            Link::make('Back')
                ->icon('arrow-left')
                ->canSee(!$this->is_multi_layout)
                ->route('school.receipt.list', ['admission_id' => $this->admission_id]),
            Link::make('Print')
                ->icon('printer')
                ->type(Color::WARNING())
                ->href("javascript:printReport('{$this->fileName}', '" . env('APP_URL') . "')"),
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
            Layout::view('reports.fees-receipt'),
        ];
    }
}
