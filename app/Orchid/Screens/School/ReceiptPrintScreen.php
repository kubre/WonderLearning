<?php

namespace App\Orchid\Screens\School;

use App\Models\Receipt;
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


    public int $admission_id;

    public bool $is_multi_layout = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(int $receipt_id, string $parent): array
    {
        $receipt = Receipt::with('admission.student.school')->findOrFail($receipt_id);
        $this->admission_id = $receipt->admission_id;
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
                ->href('javascript:(function(){window.print();})()'),
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
