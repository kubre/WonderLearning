<?php

namespace App\Orchid\Screens\School;

use App\Http\Requests\AdmissionRequest;
use App\Models\Admission;
use App\Models\Enquiry;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public $permission = 'admission.edit';

    public bool $exists = false;

    protected string $current_year;

    protected string $current_year_start;

    protected string $next_year;

    protected string $next_year_start;

    protected array $working_year;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Admission $admission): array
    {
        $this->exists = $admission->exists;
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

        $data = [];
        $enquirer = null;

        if (!is_null(request('enquirerId'))) {
            $enquiry = Enquiry::findOrFail(request('enquirerId'))->toArray();
            $enquirer = request('enquirer');
        }

        if (!$this->exists) {
            $enquiry[$enquirer . '_name'] = $enquiry['enquirer_name'];
            $enquiry[$enquirer . '_contact'] = $enquiry['enquirer_contact'];
            $enquiry[$enquirer . '_email'] = $enquiry['enquirer_email'];
            $enquiry['admission_at'] = today()->format('Y-m-d');
            $data = $enquiry;
        } else {
            $this->name = 'Update Admission Details';
            $data = $admission->student->toArray();
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
                ->type(Color::PRIMARY())
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
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
                        ->options([
                            'Playgroup' => 'Playgroup',
                            'Nursery' => 'Nursery',
                            'Junior KG' => 'Junior KG',
                            'Senior KG' => 'Senior KG',
                        ])
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
                    Select::make('fees_installments')
                        ->options(array_combine(range(1, 12), range(1, 12)))
                        ->title('No of Fees Installments'),
                    Input::make('discount')
                        ->title('Discount')
                ]),
                Group::make([
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
        $student = new Student;
        if ($this->exists) {
            $student = $admission->student;
        }

        $form = $request->all();
        $form['school_id'] = auth()->user()->school_id;

        $student->fill($form)->save();

        $form['student_id'] = $student->id;
        $admission->fill($form)->save();

        Toast::info('Admission of student was done successfully!');
        return redirect()->route('school.admission.list');
    }
}
