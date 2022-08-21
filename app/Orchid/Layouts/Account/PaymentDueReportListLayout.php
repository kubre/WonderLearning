<?php

namespace App\Orchid\Layouts\Account;

use App\Models\Admission;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Str;

class PaymentDueReportListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'admissions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        $f = $this->query->get('fees');
        return [
            TD::make('prn', 'PRN')
                ->align(TD::ALIGN_CENTER),
            // TD::make('admission_at', 'Admission Date')
            //     ->align(TD::ALIGN_CENTER),
            TD::make('student_name', 'Name')
                ->align(TD::ALIGN_CENTER)
                ->render(fn (Admission $a) => wordwrap($a->student->name, 15, '<br>')),
            TD::make('program', 'Program Name')
                ->align(TD::ALIGN_CENTER),
            TD::make('invoice_no', 'Invoice No')
                ->align(TD::ALIGN_CENTER),
            TD::make('admission_at', 'Admission At')
                ->align(TD::ALIGN_CENTER)
                ->render(fn (Admission $a) => $a->admission_at->format('d-M-Y')),
            TD::make('invoice_amount', 'Invoice Amount')
                ->align(TD::ALIGN_RIGHT)
                ->render(fn (Admission $a) => $f->{$a->fees_total_column}),
            TD::make('discount', 'Discount Applicable')
                ->align(TD::ALIGN_RIGHT),
            TD::make('school_fees_receipts_sum', 'Amount Received')
                ->align(TD::ALIGN_RIGHT)
                ->render(fn (Admission $a) => $a->school_fees_receipts_sum_amount ?? '0'),
            TD::make('balance_amount', 'Due Amount')
                ->align(TD::ALIGN_RIGHT)
                ->render(fn (Admission $a) =>
                $f->{$a->fees_total_column} - $a->discount - $a->school_fees_receipts_sum_amount),
        ];
    }

    public function total(): array
    {
        return [
            TD::make('total')
                ->align(TD::ALIGN_RIGHT)
                ->colspan(5)
                ->render(fn () => 'Total:'),

            TD::make('total_invoice_amount')
                ->align(TD::ALIGN_RIGHT),

            TD::make('total_discount')
                ->align(TD::ALIGN_RIGHT),

            TD::make('total_school_fees_receipts_sum')
                ->align(TD::ALIGN_RIGHT),

            TD::make('total_balance_amount')
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
