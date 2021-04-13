<?php

namespace App\Orchid\Screens\Account;

use App\Models\Admission;
use App\Orchid\Layouts\Account\PaymentDueReportListLayout;
use App\Orchid\Layouts\Account\ProgramSelectionLayout;
use Illuminate\Database\Eloquent\Collection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class PaymentDueReportScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Payment Due Report';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'See and export payment due report.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        /** @var Collection */
        $admissions = Admission::with(['student.school'])
            ->withSum('school_fees_receipts', 'amount')
            ->filtersApplySelection(ProgramSelectionLayout::class)
            ->get();

        if ($admissions->isNotEmpty()) {
            $fees = $admissions->first()->student->school->fees;

            $total_invoice_amount = $admissions->sum(fn ($a) => $fees->{$a->fees_total_column});
            $total_school_fees_receipts_sum = $admissions->sum('school_fees_receipts_sum_amount');
            $total_balance_amount = $admissions->sum(fn ($a) =>
            $fees->{$a->fees_total_column} - $a->discount - $a->school_fees_receipts_sum_amount);

            return [
                'admissions' => $admissions,
                'fees' => $fees,
                'total_discount' => $admissions->sum('discount'),
                'total_invoice_amount' => $total_invoice_amount,
                'total_school_fees_receipts_sum' => $total_school_fees_receipts_sum,
                'total_balance_amount' => $total_balance_amount,
            ];
        }

        return [
            'admissions' => [],
            'fees' => null,
            'total_discount' => null,
            'total_invoice_amount' => null,
            'total_school_fees_receipts_sum' => null,
            'total_balance_amount' => null,
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
            Link::make('Export to Excel')
                ->icon('table')
                ->class('btn export-csv')
                ->type(Color::SUCCESS())
                ->href('javascript:exportCsv()')
                ->rawClick(true),

            Link::make('Print/Export PDF')
                ->icon('printer')
                ->type(Color::PRIMARY())
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
        return [
            ProgramSelectionLayout::class,
            PaymentDueReportListLayout::class,
        ];
    }
}
