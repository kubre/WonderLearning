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
use App\Models\Admission;
use App\Orchid\Layouts\ExportListener;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Orchid\Support\Color;
use Storage;

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
    public $description = 'Data Export Screen for current working year';

    public const EXPORT_INDEX = [
        'users' => UsersExport::class,
        'schools' => SchoolExport::class,
        'enquiries' => EnquiryExport::class,
        'admissions' => AdmissionExport::class,
        'fees' => FeesExport::class,
        'receipts' => ReceiptExport::class,
        'kits' => KitStockExport::class,
    ];

    public $permission = 'admin.export';

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
            ExportListener::class,
            // Layout::rows([
            //     DateTimer::make('from_date')
            //         ->format('Y-m-d')
            //         ->help('Optional: If not provided Data from Beginning will be downloaded')
            //         ->title('From Date'),
            //     DateTimer::make('to_date')
            //         ->format('Y-m-d')
            //         ->help('Optional: If not provided Data till today will be downloaded')
            //         ->title('Up To Date'),
            // ])
        ];
    }

    public function exportXlsx(Request $request)
    {
        $model = static::EXPORT_INDEX[$request->model] ?? null;
        abort_if(is_null($model), 404, 'Data Model Not Found');

        $exportObj = new $model(...\working_year());

        if ($request->model !== 'admissions') {
            return Excel::download(
                $exportObj,
                $request->get('model') . '_' . now()->toDateTimeString() . '.xlsx'
            );
        }

        $excel = 'excel.xlsx';
        $zipFile = Storage::disk('temp')->path('student_data.zip');

        Excel::store($exportObj, $excel, 'temp');

        $admissions = Admission::with('student.school')
            ->when(
                !is_null($request->school_id),
                function ($query) use ($request) {
                    $query->where('school_id', $request->school_id);
                }
            )
            ->whereHas('student', function ($query) {
                $query->whereNotNull('photo');
            })
            ->get();

        $zip = new \ZipArchive();
        $zip->open(
            $zipFile,
            \ZipArchive::CREATE | \ZipArchive::OVERWRITE
        );

        $zip->addFile(Storage::disk('temp')->path($excel), 'data.xlsx');
        $admissions->each(function (Admission $admission) use ($zip) {
            $tmp = \explode('.', $admission->student->photo);
            $extension = end($tmp);
            $zip->addFile(
                public_path($admission->student->photo),
                str_replace('/', '-', $admission->student->prn) . '.' . $extension
            );
        });

        $zip->close();

        return Storage::disk('temp')->download('student_data.zip');
    }


    public function asyncUpdatedModel(Request $request)
    {
        return [
            'model' => $request->model,
        ];
    }
}
