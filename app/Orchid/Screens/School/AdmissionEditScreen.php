<?php

namespace App\Orchid\Screens\School;

use App\Http\Requests\AdmissionRequest;
use App\Models\Admission;
use App\Models\Enquiry;
use App\Models\Fees;
use App\Models\School;
use App\Models\Student;
use Illuminate\Support\Str;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class AdmissionEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Convert to Admission';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Fill the following form to convert/edit to an Admission.';

    /** @var array|string */
    public $permission = 'admission.edit';

    public bool $exists = false;

    protected string $current_year;

    protected string $current_year_start;

    protected string $next_year;

    protected string $next_year_start;

    protected array $working_year;

    protected bool $disable_save = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Admission $admission): array
    {
        $this->exists = $admission->exists;
        $data = [];
        $enquirer = null;

        if (!is_null(request('enquirerId'))) {
            $enquiry = Enquiry::findOrFail(request('enquirerId'));
            $enquirer = request('enquirer');
        }

        if (!$this->exists) {
            $fees = Fees::first();
            $program_fees = optional($fees)->{Str::of($enquiry->program)->lower()->snake() . '_total'};

            if (is_null($program_fees) || $program_fees < 1) {
                $this->disable_save = true;
                Toast::error("Please add fees rate card for next year first!");
            }
            $data = $enquiry->toArray();
            $data[$enquirer . '_name'] = $enquiry->enquirer_name;
            $data[$enquirer . '_contact'] = $enquiry->enquirer_contact;
            $data[$enquirer . '_email'] = $enquiry->enquirer_email;
            $data['enquirer_id'] = $enquiry->id;
            $data['admission_at'] = today()->format('Y-m-d');
            $data['code'] = (Student::max('code') ?? 0) + 1;
        } else {
            $this->name = 'Update Admission Details';
            $data = $admission->student->toArray();
            $data['prn'] = $admission->student->prn;
        }

        $this->working_year = working_year();
        $this->current_year_start = (string) $this->working_year[0];
        $this->current_year = get_academic_year_formatted($this->working_year);
        if (today()->isBetween(...$this->working_year)) {
            $academic_year = get_academic_year(today()->addYear());
            $this->next_year_start = (string) $academic_year[0];
            $this->next_year = get_academic_year_formatted($academic_year);
        } else {
            $this->next_year = $this->current_year;
            $this->next_year_start = $this->current_year_start;
        }

        return array_merge($data, $admission->toArray());
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
                ->disabled($this->disable_save)
                ->type(Color::PRIMARY())
                ->method('createOrUpdate')
                ->canSee(!$this->exists && auth()->user()->hasAccess('admission.create')),

            Button::make('Update Details')
                ->icon('note')
                ->method('createOrUpdate')
                ->type(Color::PRIMARY())
                ->canSee($this->exists),

            // Button::make('Remove')
            //     ->icon('trash')
            //     ->method('remove')
            //     ->type(Color::DANGER())
            //     ->canSee($this->exists),
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
                Input::make('enquirer_id')
                    ->hidden(),
                Input::make('prn')
                    ->title('PRN')
                    ->canSee($this->exists)
                    ->readonly(),
                Input::make('code')
                    ->hidden(),
                Group::make([
                    Cropper::make('photo')
                        ->title('Passport Size photo')
                        ->maxFileSize(0.5)
                        ->targetRelativeUrl()
                        ->height(450)
                        ->width(350),
                    Select::make('created_at')
                        ->title('Admission Academic Year')
                        ->options([
                            $this->current_year_start => $this->current_year,
                            $this->next_year_start => $this->next_year,
                        ]),
                    DateTimer::make('admission_at')
                        ->format('Y-m-d')
                        ->enableTime(false)
                        ->title('Admission Date')
                ]),
                Group::make([
                    Input::make('name')
                        ->title('Name'),
                    Select::make('gender')
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                            'Transgender' => 'Transgender',
                            'Other' => 'Other',
                        ])
                        ->title('Gender'),
                    DateTimer::make('dob_at')
                        ->format('Y-m-d')
                        ->noCalendar()
                        ->enableTime(false)
                        ->title('Date of Birth')
                ]),
                Group::make([
                    Input::make('nationality')
                        ->title('Nationality'),
                    Select::make('program')
                        ->options(School::PROGRAMMES)
                        ->required()
                        ->title('Program'),
                ]),
            ])->title('Basic Details'),
            Layout::columns([
                Layout::rows([
                    Input::make('father_name')
                        ->title('Name'),
                    Input::make('father_email')
                        ->title('Email')
                        ->type('email'),
                    Input::make('father_contact')
                        ->mask('9999999999')
                        ->title('Contact'),
                    Input::make('father_occupation')
                        ->title('Occupation'),
                    Input::make('father_organization')
                        ->title('Organization'),
                ])->title('Father\'s Details'),
                Layout::rows([
                    Input::make('mother_name')
                        ->title('Name'),
                    Input::make('mother_email')
                        ->title('Email')
                        ->type('email'),
                    Input::make('mother_contact')
                        ->mask('9999999999')
                        ->title('Contact'),
                    Input::make('mother_occupation')
                        ->title('Occupation'),
                    Input::make('mother_organization')
                        ->title('Organization'),
                ])->title('Mother\'s Details'),
            ]),
            Layout::rows([
                Group::make([
                    Input::make('address')
                        ->title('Address'),
                    Input::make('city')
                        ->title('City'),
                ]),
                Group::make([
                    Input::make('state')
                        ->title('State'),
                    Input::make('pincode')
                        ->mask('999999')
                        ->title('Pin Code'),
                ]),
            ])->title('Address Details'),
            Layout::rows([
                Group::make([
                    Input::make('discount')
                        ->value(0)
                        ->title('Discount'),
                    Select::make('batch')
                        ->options([
                            'Morning' => 'Morning',
                            'Afternoon' => 'Afternoon',
                        ])
                        ->title('Batch'),
                    CheckBox::make('is_transportation_required')
                        ->sendTrueOrFalse()
                        ->title('Transportation Required')
                        ->placeholder('Check this for yes'),
                ]),
                Matrix::make('siblings')
                    ->title(('Siblings'))
                    ->columns([
                        'Name' => 'sibling_name',
                        'Date of Birth' => 'sibling_dob',
                    ])
                    ->fields(['sibling_dob' => DateTimer::make('')->format('d-m-Y')])
                    ->maxRows(5)
            ])->title('Other Details'),
        ];
    }

    public function createOrUpdate(Admission $admission, AdmissionRequest $request)
    {
        $student = new Student();
        $newAdmission = !$admission->exists;

        if ($admission->exists) {
            $student = $admission->student;
        }

        $student->fill($request->input())->save();

        $student->admission()->save(
            $admission->fill($request->input())
        );

        if (!is_null($request->input('enquirer_id'))) {
            Enquiry::find($request->input('enquirer_id'))
                ->fill([
                    'student_id' => $student->id,
                ])->save();
        }

        Toast::info('Admission of student was done successfully!');

        if ($newAdmission) {
            return redirect()->route('school.installment.edit', [
                'admission' => $admission->id,
            ]);
        }
        return redirect()->route('school.admission.list');
    }
}
