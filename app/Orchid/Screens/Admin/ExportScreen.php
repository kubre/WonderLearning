<?php

namespace App\Orchid\Screens\Admin;

use App\Exports\{
    AdmissionExport,
    EnquiryExport,
    FeesExport,
    ReceiptExport,
    SchoolExport,
    UsersExport,
    KitStockExport,
};
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Orchid\Support\Color;

class ExportScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Export Screen';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Data Export Screen';

    public const EXPORT_INDEX = [
        'users' => UsersExport::class,
        'schools' => SchoolExport::class,
        'enquiries' => EnquiryExport::class,
        'admissions' => AdmissionExport::class,
        'fees' => FeesExport::class,
        'receipts' => ReceiptExport::class,
        'kits' => KitStockExport::class,
    ];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Download')
                ->method('exportXlsx')
                ->icon('cloud-download')
                ->type(Color::SUCCESS())
                ->rawClick(),
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
            Layout::rows([
                Select::make('model')
                    ->title('Data Model')
                    ->options([
                        'users' => 'Users',
                        'schools' => 'Schools',
                        'enquiries' => 'Enquiries',
                        'admissions' => 'Admissions',
                        'fees' => 'School Fees',
                        'receipts' => 'Receipts',
                        'kits' => 'Kit Stocks',
                    ]),
                DateTimer::make('from_date')
                    ->format('Y-m-d')
                    ->help('Optional: If not provided Data from Beginning will be downloaded')
                    ->title('From Date'),
                DateTimer::make('to_date')
                    ->format('Y-m-d')
                    ->help('Optional: If not provided Data till today will be downloaded')
                    ->title('Up To Date'),
            ])
        ];
    }

    public function exportXlsx(Request $request)
    {
        $model = static::EXPORT_INDEX[$request->model] ?? null;
        abort_if(is_null($model), 404, 'Data Model Not Found');

        return Excel::download(
            new $model($request->from_date, $request->to_date),
            $request->get('model') . '_' . now()->toDateTimeString() . '.xlsx'
        );
    }
}
