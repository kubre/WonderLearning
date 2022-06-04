<?php

namespace App\Orchid\Screens\Student;

use App\Models\Admission;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class InvoicePrintScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Print Invoice';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Print invoice details';


    public string $fileName = 'invoice_';

    /**
     * Query data.
     *
     * @return array
     */
    public function query($admission, string $parent): array
    {
        $admissionObj = Admission::withoutGlobalScopes()->findOrFail($admission);
        $this->fileName .= $admissionObj->student->name . '_' . $admissionObj->invoice_no;
        return [
            'admission' => $admissionObj,
            'parent' => $parent
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
            Link::make('Back')
                ->icon('arrow-left')
                ->route('school.admission.list'),
            Link::make('Print')
                ->icon('printer')
                ->type(Color::WARNING())
                ->href("javascript:printReport('{$this->fileName}', '" . env('APP_URL') . "')"),
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
            Layout::view('reports.fees-invoice'),
        ];
    }
}
