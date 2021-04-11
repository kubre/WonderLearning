<?php

namespace App\Orchid\Layouts\Account;

use App\Models\Receipt;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OnlinePaymentListLayout extends Table
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
        return [
            TD::make('prn', 'PRN')
                ->render(fn ($r) => $r->admission->prn),
            TD::make('student_name', 'Name')
                ->align(TD::ALIGN_CENTER)
                ->render(fn (Receipt $r) => wordwrap($r->admission->student->name, 35, '<br>')),
            TD::make('receipt_no', 'Receipt No')
                ->align(TD::ALIGN_CENTER)
                ->render(fn (Receipt $r) => str_pad($r->receipt_no, 6, '0', STR_PAD_LEFT)),
            TD::make('transaction_no', 'Transaction ID')
                ->align(TD::ALIGN_CENTER),
            TD::make('paid_at', 'Payment At')
                ->align(TD::ALIGN_CENTER)
                ->render(fn (Receipt $r) => $r->paid_at->format('d-M-y')),
            TD::make('amount', 'Amount (₹)')
                ->align(TD::ALIGN_RIGHT),
        ];
    }

    public function total(): array
    {
        return [
            TD::make('total')
                ->colspan(5)
                ->render(fn () => 'Total:'),

            TD::make('total_amount')
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
