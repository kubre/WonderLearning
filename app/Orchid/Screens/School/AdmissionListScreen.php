<?php

namespace App\Orchid\Screens\School;

use App\Models\Admission;
use App\Models\Division;
use App\Models\Fees;
use App\Models\KitStock;
use App\Models\Scopes\AcademicYearScope;
use App\Orchid\Layouts\Account\ProgramSelectionLayout;
use App\Orchid\Layouts\School\AdmissionListLayout;
use App\Orchid\Layouts\School\DivisionRow;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

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
            'admissions' => Admission::query()
                ->filters()
                ->filtersApplySelection(ProgramSelectionLayout::class)
                ->with(['student.school', 'division'])
                ->simplePaginate(50),
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
            ProgramSelectionLayout::class,
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
            Layout::modal('asyncAssignDivision', [
                DivisionRow::class,
            ])
                ->applyButton('Assign')
                ->closeButton('Cancel')
                ->async('asyncGetDivisions'),
        ];
    }

    /** Get data for division row for division assignment */
    public function asyncGetDivisions(int $admission_id, string $program): array
    {
        return [
            'divisions' => Division::select(['id', 'title'])
                ->whereProgram($program)
                ->get()
                ->mapWithKeys(fn ($d) => [$d->id => $d->title])
                ->toArray(),
        ];
    }

    public function assignDivision(
        Admission $admission,
        string $program,
        Request $request
    ): \Illuminate\Http\RedirectResponse {
        $admission->fill($request->input())->save();
        return redirect()->route('school.admission.list');
    }

    public function issueInvoice(int $admission_id): RedirectResponse
    {
        return redirect()->route('school.invoice.print', [
            'admission' => $admission_id,
            'parent' => request('parent'),
        ]);
    }

    public function assignKit(Admission $admission)
    {
        $kitStock = KitStock::withoutGlobalScope(AcademicYearScope::class)
            ->whereDate('created_at', $admission->created_at)
            ->firstOrFail();

        if (
            $kitStock->{$admission->fees_column . '_total'}
            - $kitStock->{$admission->fees_column . '_assigned'} < 1
        ) {
            Toast::warning('Not enough kits available for this program please update the total count.');
            return redirect()->route('school.admission.list');
        }

        $kitStock->{$admission->fees_column . '_assigned'} += 1;
        $kitStock->save();
        tap(
            $admission,
            fn ($a) => $a->assigned_kit = true
        )->save();

        Toast::info('Assigned kit to the student.');
        return redirect()->route('school.admission.list');
    }
}
