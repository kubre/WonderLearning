<?php

namespace App\Orchid\Screens\Account;

use App\Models\Receipt;
use App\Orchid\Layouts\Account\CanceledLogListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class CanceledLogScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Cancelled Receipts Log';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'All the cancelled receipts for current academic year can be see here.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'receipts' => Receipt::onlyTrashed()
                ->with(['admission.student.school'])
                ->get(),
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
            CanceledLogListLayout::class
        ];
    }
}
