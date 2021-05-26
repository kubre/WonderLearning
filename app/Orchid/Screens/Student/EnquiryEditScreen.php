<?php

namespace App\Orchid\Screens\Student;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
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

    public User $user;

    /** @var array|string */
    public $permission = 'enquiry.edit';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Enquiry $enquiry): array
    {
        $this->user = auth()->user();
        $this->exists = $enquiry->exists;
        if ($this->exists) $this->name = 'Update Enquiry';
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
                ->canSee($this->user->hasAccess('enquiry.table'))
                ->route('school.enquiry.list'),

            Button::make('Save')
                ->icon('save')
                ->method('createOrUpdate')
                ->type(Color::PRIMARY()),

            Button::make('Remove')
                ->icon('trash')
                ->type(Color::DANGER())
                ->method('remove')
                ->canSee($this->user->hasAccess('enquiry.delete') && $this->exists),
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
            Layout::block([
                Layout::rows([
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
                        ->format('Y-m-d')
                        ->required(),
                ]),
            ])
                ->title('Basic Details')
                ->description('Basic details related to the child'),
            Layout::block([
                Layout::rows([
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
            ])
                ->title('Enquirers Details')
                ->description('Basic details related to the enquirer'),
            Layout::block([
                Layout::rows([
                    Input::make('locality')
                        ->title('Locality')
                        ->required(),
                    Input::make('reference')
                        ->value('No Reference')
                        ->title('Reference'),
                    DateTimer::make('follow_up_at')
                        ->title('Follow Up Date')
                        ->format('Y-m-d')
                        ->required(),
                ]),
            ])
                ->title('Other Details')
                ->description('Other miscellaneous details')
                ->commands([
                    Button::make('Save')
                        ->icon('save')
                        ->method('createOrUpdate')
                        ->type(Color::PRIMARY()),
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
        $request->validate([
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

        $enquiry->fill($request->input())->save();

        Toast::info('Added details successfully!');
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

        Toast::info('You have successfully deleted the enquiry!');

        return redirect()->route('school.enquiry.list');
    }
}
