<?php

namespace App\Orchid\Screens\Student;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;

class EnquiryEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Save Enquiry';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Manage Enquiry';

    /** @var bool */
    public $exists;

    /** @var int */
    public $school_id;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Enquiry $enquiry): array
    {
        $this->school_id = auth()->user()->school->id;
        $this->exists = $enquiry->exists;
        if($this->exists) $this->name = 'Update Enquiry';
        return $enquiry->toArray();
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
                ->route('school.enquiry.list'),

            Button::make('Save School')
                ->icon('save')
                ->method('createOrUpdate')
                ->type(Color::PRIMARY())
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->icon('trash')
                ->type(Color::DANGER())
                ->method('remove')
                ->canSee($this->exists),
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
                    Input::make('name')
                        ->title('Name')
                        ->required(),
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
                Group::make([
                    Select::make('gender')
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                            'Transgender' => 'Transgender',
                            'Other' => 'Other',
                        ])
                        ->title('Gender')
                        ->required(),
                    DateTimer::make('dob_at')
                        ->title('Date of Birth')
                        ->required()
                ]),
                Group::make([
                    Input::make('enquirer_name')
                        ->title('Enquirer Name')
                        ->required(),
                    Input::make('enquirer_email')
                        ->title('Enquirer Email')
                        ->required(),
                    Input::make('enquirer_contact')
                        ->mask('9999999999')
                        ->title('Enquirer Contact')
                        ->required(),
                ]),
                Group::make([
                    Input::make('locality')
                        ->title('Locality')
                        ->required(),
                    Input::make('reference')
                        ->title('Reference')
                        ->required(),
                    DateTimer::make('follow_up_at')
                        ->title('Follow Up Date')
                        ->required(),
                ]),
            ]),
        ];
    }

     /**
     * @param Enquiry $enquiry
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Enquiry $enquiry, Request $request)
    {
        $form = $request->validate([
            'name' => 'required',
            'gender' => 'required|in:Male,Female,Transgender,Other',
            'dob_at' => 'required|date',
            'program' => 'required',
            'enquirer_name' => 'required',
            'enquirer_email' => 'required|email',
            'enquirer_contact' => 'required|digits:10',
            'locality' => 'required',
            'reference' => 'required',
            'follow_up_at' => 'required|date',
        ]);
        $form['school_id'] = $this->school_id;
        
        $enquiry->fill($form)->save();
        Toast::info(($this->exists ? 'Updated' : 'Added').' details successfully!');
        return redirect()->route('school.enquiry.list');
    }

    /**
     * @param Enquiry $enquiry
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Enquiry $enquiry)
    {
        $enquiry->delete();

        Toast::info('You have successfully deleted the enquiry.');

        return redirect()->route('school.enquiry.list');
    }
}
