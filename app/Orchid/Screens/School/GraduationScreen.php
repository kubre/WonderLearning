<?php

namespace App\Orchid\Screens\School;

use App\Http\Requests\AdmissionRequest;
use App\Models\Admission;
use App\Models\Fees;
use App\Models\Scopes\AcademicYearScope;
use Illuminate\Support\Str;
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
use Orchid\Support\Facades\Toast;

class GraduationScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Graduate Student';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Graduate student to next programme or retain them to the same.';


    protected const GRADUATIONS_MAP = [
        'Playgroup' => 'Nursery',
        'Nursery' => 'Junior KG',
        'Junior KG' => 'Senior KG',
    ];

    protected const GRADUATIONS = [
        'Playgroup' => [
            'Nursery' => 'Nursery',
            'Playgroup' => 'Playgroup',
        ],
        'Nursery' => [
            'Junior KG' => 'Junior KG',
            'Nursery' => 'Nursery',
        ],
        'Junior KG' => [
            'Senior KG' => 'Senior KG',
            'Junior KG' => 'Junior KG',
        ],
    ];

    protected const PROGRAMMES = [
        'Playgroup' => 'Playgroup',
        'Nursery' => 'Nursery',
        'Junior KG' => 'Junior KG',
        'Senior KG' => 'Senior KG',
    ];

    public string $program;

    public bool $disable_graduate = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query($admission): array
    {
        $admissionObj = Admission::withoutGlobalScopes()->findOrFail($admission);
        $student = $admissionObj->student->toArray();
        $student['prn'] = $admissionObj->student->prn;

        $academic_year = get_academic_year($admissionObj->created_at->addYear());

        $fees = Fees::withoutGlobalScope(AcademicYearScope::class)
            ->whereBetween('created_at', $academic_year)
            ->first();
        $program_fees = optional($fees)->{$admissionObj->fees_total_column};
        $graduate_fees = optional($fees)->{Str::of(static::GRADUATIONS_MAP[$admissionObj->program])
            ->lower()->snake() . '_total'};

        if (
            is_null($program_fees)
            || is_null($graduate_fees)
            || $program_fees < 1
            || $graduate_fees < 1
        ) {
            $this->disable_graduate = true;
            Toast::error("Please add fees rate card for next year first!");
        }

        $admissionObj = $admissionObj->toArray();

        $admissionObj['discount'] = null;
        $admissionObj['is_transportation_required'] = null;
        $this->program = $admissionObj['program'];
        $admissionObj['program'] = static::GRADUATIONS_MAP[$this->program];

        $admissionObj['created_at'] = $academic_year[0];
        $admissionObj['created_at_dummy'] = get_academic_year_formatted($academic_year);

        return array_merge($student, $admissionObj);
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Graduate')
                ->icon('note')
                ->method('graduate')
                ->disabled($this->disable_graduate)
                ->type(Color::PRIMARY()),
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
                Input::make('prn')
                    ->title('PR Number')
                    ->readonly(),
                Input::make('created_at')
                    ->hidden(),
                Input::make('code')
                    ->hidden(),
                Group::make([
                    Cropper::make('photo')
                        ->title('Passport Size photo')
                        ->maxFileSize(0.5)
                        ->targetRelativeUrl()
                        ->height(450)
                        ->width(350),
                    Input::make('created_at_dummy')
                        ->readonly()
                        ->title('Admission Academic Year'),
                    DateTimer::make('admission_at')
                        ->format('Y-m-d')
                        ->enableTime(false)
                        ->title('Admission Date'),
                ]),
                Group::make([
                    Input::make('name')
                        ->readonly()
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
                        ->readonly()
                        ->format('Y-m-d')
                        ->noCalendar()
                        ->enableTime(false)
                        ->title('Date of Birth')
                ]),

                Group::make([
                    Input::make('nationality')
                        ->title('Nationality'),

                    Select::make('program')
                        ->options(static::GRADUATIONS[$this->program])
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


    public function graduate(Admission $admission, AdmissionRequest $request)
    {
        $student = $admission->student;

        $student->fill($request->except('created_at'))->save();

        $admission_attr = $request->all();
        $admission_attr['school_id'] = $student->school_id;
        $admission = $student->admission()->create($admission_attr);

        Toast::info('Student graduated to next programme successfully!');

        return redirect()->route('school.installment.edit', [
            'admission' => $admission->id
        ]);
    }
}
