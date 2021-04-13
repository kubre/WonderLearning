<?php

namespace App\Orchid\Screens\Account;

use App\Models\Receipt;
use App\Orchid\Layouts\Account\DailyCollectionReportListLayout;
use App\Orchid\Layouts\Account\ReceiptDateSelectionLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class DailyCollectionReportScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Daily Collection Report';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Daily collection report.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        if (request()->has('from_date') && request()->has('to_date')) {
            /** @var Collection */
            $receipts = Receipt::filtersApplySelection(ReceiptDateSelectionLayout::class)
                ->with('admission.student.school')
                ->get();

            $totals = $receipts->groupBy('payment_mode')->map(fn ($c) => $c->sum('amount'));

            return [
                'receipts' => $receipts,
                'total_cash' => $totals->get(Receipt::MODE_CASH),
                'total_bank' => $totals->get(Receipt::MODE_BANK),
                'total_online_payments' => $totals->get(Receipt::MODE_ONLINE_PAYMENTS),
                'total_amount' => $totals->sum(),
            ];
        }
        return [
            'receipts' => [],
            'total_amount' => 'Select From and To Date to view Daily Collections',
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
        return [
            ReceiptDateSelectionLayout::class,
            DailyCollectionReportListLayout::class,
        ];
    }
}
