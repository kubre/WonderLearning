<?php

namespace App\Orchid\Layouts;

use App\Models\Receipt;
use App\Orchid\Screens\School\ReceiptListScreen;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ReceiptListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'receipts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        $is_multi_layout = is_null($this->query->get('admission'));
        return [
            TD::make('receipt_no', 'Receipt No')
                ->render(fn (Receipt $r) => str_pad($r->receipt_no, 6, '0', STR_PAD_LEFT)),
            TD::make('receipt_at', 'Receipt Date'),
            TD::make('bank_name', 'Bank Name'),
            TD::make('bank_branch', 'Bank Branch'),
            TD::make('transaction_no', 'Cheque/Transaction No'),
            TD::make('paid_at', 'Cheque/Transaction Date'),
            TD::make('amount', 'Amount')
                ->align(TD::ALIGN_RIGHT),
            TD::make('student_id', 'Student Name')
                ->canSee($is_multi_layout)
                ->render(fn (Receipt $r) => $r->admission->student->name),
            TD::make('action', 'Action')
                ->render(
                    fn (Receipt $r) =>
                    DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Button::make('Delete')
                                ->icon('trash')
                                ->method('cancel')
                                ->confirm("Once deleted this can not be restored are you sure?")
                                ->canSee(auth()->user()->hasAccess('receipt.delete'))
                                ->parameters([
                                    'id' => $r->id,
                                ]),
                            Button::make('Request Delete')
                                ->icon('trash')
                                ->method('requestDelete')
                                ->canSee(!auth()->user()->hasAccess('receipt.delete'))
                                ->confirm("Once deleted this can not be restored are you sure?")
                                ->parameters([
                                    'id' => $r->id,
                                ]),
                            ModalToggle::make('Print')
                                ->icon('printer')
                                // ->canSee($this->user->hasAccess('admission.create'))
                                ->modal('chooseReceiptReceiversName')
                                ->modalTitle('Print Receipt')
                                ->method('issueReceipt')
                                ->asyncParameters([
                                    'receipt' => $r->id,
                                    'object' => ReceiptListScreen::OPTION_PRINT,
                                    'is_multi_layout' => $is_multi_layout,
                                ]),

                            ModalToggle::make('Email')
                                ->icon('share')
                                ->canSee(false)
                                ->modal('chooseReceiptReceiversName')
                                ->modalTitle('Email Receipt')
                                ->method('issueReceipt')
                                ->asyncParameters([
                                    'receipt' => $r->id,
                                    'object' => ReceiptListScreen::OPTION_EMAIL,
                                    'is_multi_layout' => $is_multi_layout,
                                ]),
                        ])
                ),
        ];
    }

    public function total(): array
    {
        return [
            TD::make('total')
                ->colspan(6)
                ->render(fn () => 'Total:'),

            TD::make('total_fees')
                ->render(fn () => $this->query->get('receipts')->sum('amount'))
                ->align(TD::ALIGN_RIGHT),
        ];
    }

    /**
     * Usage for zebra-striping to any table row.
     *
     * @return bool
     */
    protected function striped(): bool
    {
        return true;
    }

    /**
     * Usage for borders on all sides of the table and cells.
     *
     * @return bool
     */
    protected function bordered(): bool
    {
        return true;
    }
}
