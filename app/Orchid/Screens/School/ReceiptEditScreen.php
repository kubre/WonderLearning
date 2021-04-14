<?php

namespace App\Orchid\Screens\School;

use App\Models\Admission;
use App\Models\Receipt;
use App\Models\Scopes\AcademicYearScope;
use App\Models\Student;
use App\Models\User;
use App\Orchid\Layouts\ReceiptModeListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ReceiptEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Add Receipt';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Add Receipt into the records.';

    /** @var array|string */
    public $permission = 'receipt.edit';

    public bool $exists = false;

    public bool $is_school_fees_receipt = false;

    public User $user;

    public ?string $for;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Receipt $receipt): array
    {
        $this->exists = $receipt->exists;
        $this->user = auth()->user();
        $this->for = request('for');
        $this->is_school_fees_receipt = $this->for === Receipt::SCHOOL_FEES;
        $data = [
            'admission_id' => request('admission_id'),
            'for' => $this->for,
        ];

        if ($this->exists) {
            $this->name = 'Edit Receipt';
        } else {
            $data['receipt_no'] = (Receipt::withoutGlobalScope(AcademicYearScope::class)
                ->max('receipt_no') ?? 0) + 1;
        }

        return array_merge($receipt->toArray(), $data);
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
                ->href(url()->previous()),

            Button::make('Save Receipt')
                ->icon('save')
                ->method('createOrUpdate')
                ->type(Color::PRIMARY())
                ->canSee(!$this->exists && $this->user->hasAccess('receipt.create')),

            Button::make('Update Receipt')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->user->hasAccess('receipt.edit') && $this->exists),

            // Button::make('Remove')
            //     ->icon('trash')
            //     ->type(Color::DANGER())
            //     ->method('remove')
            //     ->canSee($this->user->hasAccess('receipt.delete') && $this->exists),
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
                Input::make('receipt_no')
                    ->title('Receipt No')
                    ->readonly()
                    ->required(),
                Select::make('admission_id')
                    ->title('Student')
                    ->fromQuery(Admission::with('student.school'), 'search_title')
                    ->canSee(!$this->is_school_fees_receipt),
                Input::make('admission_id')
                    ->type('hidden')
                    ->canSee($this->is_school_fees_receipt),
                Input::make('amount')
                    ->title('Amount')
                    ->autofocus()
                    ->tabindex(1)
                    ->required(),
                DateTimer::make('receipt_at')
                    ->title('Receipt Date')
                    ->tabindex(2)
                    ->format('Y-m-d')
                    ->enableTime(false),
                Input::make('for')
                    ->title('Receipt For')
                    ->help('ex. Event, Trip, etc., NOTE: Do not add School Fees from here')
                    ->tabindex(3)
                    ->readonly($this->is_school_fees_receipt)
                    ->required(),
                Select::make('payment_mode')
                    ->tabindex(4)
                    ->options(Receipt::PAYMENT_MODES)
                    ->title('Payment Mode')
                    ->required(),
            ]),
            ReceiptModeListener::class,
        ];
    }

    public function createOrUpdate(Receipt $receipt, Request $request)
    {
        $form = $request->validate([
            'admission_id' => 'required',
            'receipt_no' => 'required|integer',
            'amount' => 'required|integer|min:1',
            'for' => 'required',
            'payment_mode' => 'required|in:c,o,b',
            'bank_name' => 'nullable',
            'bank_branch' => 'nullable',
            'transaction_no' => 'nullable',
            'paid_at' => 'nullable|date',
            'receipt_at' => 'required|date',
        ]);

        $admission = Admission::findOrFail($form['admission_id']);

        if ($form['amount'] > $admission->balance_amount) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['amount' => 'Amount cannot be greater than student\'s balance amount!']);
        }

        $form['school_id'] = auth()->user()->school_id;
        if (!$receipt->exists) $form['created_at'] = working_year()[0];

        $receipt->fill($form)->save();

        $data = [];
        if ($request->input('for') === Receipt::SCHOOL_FEES) {
            $data['admission_id'] = $form['admission_id'];

            $this->deductFromInstallments($form['amount'], $admission->unpaid_installments);
        }

        Toast::success('Issued the Receipt');
        return redirect()->route('school.receipt.list', $data);
    }


    /**
     * @param integer $amount
     * @param \Illuminate\Database\Eloquent\Collection $installments
     * @return void
     */
    public function deductFromInstallments(int $amount, $installments)
    {
        foreach ($installments as $installment) {
            if ($installment->due_amount >= $amount) {
                $installment->due_amount -= $amount;
                $amount = 0;
            } else {
                $amount -= $installment->due_amount;
                $installment->due_amount = 0;
            }

            $installment->save();
            if (0 === $amount) break;
        }
    }

    /**
     * @param string $mode
     * @return string[]
     */
    public function asyncPaymentMode(string $mode = '')
    {
        return [
            $mode => '',
        ];
    }
}
