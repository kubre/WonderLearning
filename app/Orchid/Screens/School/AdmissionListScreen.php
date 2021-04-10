<?php

namespace App\Orchid\Screens\School;

use App\Models\Admission;
use App\Models\Fees;
use App\Orchid\Layouts\School\AdmissionListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class AdmissionListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Manage Admission';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Manage current year\'s admissions.';

    /** @var array|string */
    public $permission = 'admission.table';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'admissions' => Admission::filters()->with(['student'])->paginate(),
            'fees' => Fees::first(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            AdmissionListLayout::class,
            Layout::modal('chooseInvoiceReceiversName', [
                Layout::rows([
                    Select::make('parent')
                        ->options([
                            'father' => 'Father\'s Name',
                            'mother' => 'Mother\'s Name',
                        ])->title('Generate Invoice with name for'),
                ]),
            ])
                ->applyButton('Generate')
                ->closeButton('Cancel'),
        ];
    }

    public function issueInvoice(int $admission_id): RedirectResponse
    {
        return redirect()->route('school.invoice.print', [
            'admission' => $admission_id,
            'parent' => request('parent'),
        ]);
    }
}
