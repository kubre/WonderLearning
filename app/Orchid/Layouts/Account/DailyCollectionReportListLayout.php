<?php

namespace App\Orchid\Layouts\Account;

use App\Models\Receipt;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DailyCollectionReportListLayout extends Table
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
            TD::make('receipt_no', 'Receipt No')
                ->render(fn (Receipt $r) => str_pad($r->receipt_no, 6, '0', STR_PAD_LEFT)),
            TD::make('cash', 'Cash')
                ->align(TD::ALIGN_RIGHT)
                ->render(fn (Receipt $r) => $r->payment_mode == Receipt::MODE_CASH ? $r->amount : ''),
            TD::make('bank', 'Cheque')
                ->align(TD::ALIGN_RIGHT)
                ->render(fn (Receipt $r) => $r->payment_mode == Receipt::MODE_BANK ? $r->amount : ''),
            TD::make('online', 'Online Payment')
                ->align(TD::ALIGN_RIGHT)
                ->render(fn (Receipt $r) => $r->payment_mode == Receipt::MODE_ONLINE_PAYMENTS ? $r->amount : ''),
        ];
    }

    public function total(): array
    {
        return [
            TD::make('total')
                ->render(fn () => 'Total: ' . $this->query->get('total_amount')),
            TD::make('total_cash')
                ->align(TD::ALIGN_RIGHT),
            TD::make('total_bank')
                ->align(TD::ALIGN_RIGHT),
            TD::make('total_online_payments')
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
