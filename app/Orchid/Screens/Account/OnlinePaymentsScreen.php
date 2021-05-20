<?php

namespace App\Orchid\Screens\Account;

use App\Models\Receipt;
use App\Orchid\Layouts\Account\DateRangeSelectionLayout;
use App\Orchid\Layouts\Account\OnlinePaymentListLayout;
use Illuminate\Database\Eloquent\Collection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class OnlinePaymentsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Online Payments Report';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Reports for online payments during current academic year.';

    public $permission = 'menu.account';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $receipts = [];
        $total_amount = 'Select From and To date to view online payment report.';
        if (request()->has('from_date') && request()->has('to_date')) {

            /** @var Collection */
            $receipts = Receipt::where('payment_mode', Receipt::MODE_ONLINE_PAYMENTS)
                ->with(['admission.student.school'])
                ->filtersApplySelection(DateRangeSelectionLayout::class)
                ->get();

            $total_amount = $receipts->sum('amount');
        }

        return [
            'receipts' => $receipts,
            'total_amount' => $total_amount,
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
            DateRangeSelectionLayout::class,
            OnlinePaymentListLayout::class,
        ];
    }
}
