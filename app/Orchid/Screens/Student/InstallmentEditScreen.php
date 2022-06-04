<?php

namespace App\Orchid\Screens\Student;

use App\Models\Admission;
use App\Models\Installment;
use App\Orchid\Layouts\InstallmentListener;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstallmentEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Fees Installments (ANNEXURE - A)';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = "Sum of all installments must add to total fees for that student. Discount is already applied in total fees!";

    /**
     * Query data.
     *
     * @return array
     */

    public function query(int $admission): array
    {
        $admissionObj = Admission::withoutGlobalScopes()->findOrFail($admission);
        return [
            'admission' => $admissionObj,
            'created_at_ref' => $admissionObj->created_at->timestamp
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
            Button::make('Save Details')
                ->icon('save')
                ->type(Color::PRIMARY())
                ->method('createOrUpdate')
                ->confirm('Are you sure? Installments CANNOT be changed later!')
                ->canSee(auth()->user()->hasAccess('admission.create')),
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
                Group::make([
                    Select::make('installment_count')
                        ->options(array_combine(range(1, 12), range(1, 12)))
                        ->title('No of Fees Installments'),
                    Input::make('admission.total_fees')
                        ->readonly()
                        ->title('Total Fees for the student'),
                ]),
            ]),
            InstallmentListener::class,
        ];
    }

    public function createOrUpdate(int $admission, Request $request)
    {
        $months = $request->input('month');
        $amounts = $request->input('amount');
        $total_amount = array_sum($amounts);

        $admissionObj = Admission::withoutGlobalScopes()->findOrFail($admission);
        $expected_fees = $admissionObj->total_fees;

        if ($total_amount !== $expected_fees) {
            return back()->withErrors([
                'amount' => "Addition of all the fees should add to the $expected_fees.",
            ]);
        }

        $now = now()->toDateTimeString();
        $data = array_map(fn ($month, $amount) => [
            'month' => $month,
            'amount' => $amount,
            'due_amount' => $amount,
            'admission_id' => $admissionObj->id,
            'school_id' => $admissionObj->school_id,
            'created_at' => $admissionObj->created_at,
            'updated_at' => $now,
        ], $months, $amounts);

        Installment::insert($data);

        Toast::info('Installments has been assigned to the student!');
        return redirect()->route('reports.declaration.form', [
            'admission' => $admissionObj->id
        ]);
    }

    public function asyncInstallmentCount(int $installment_count, $created_at_ref)
    {
        return [
            'installment_count' => $installment_count,
            'created_at_ref' => $created_at_ref
        ];
    }
}
