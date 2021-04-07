<?php

namespace App\Orchid\Screens\School;

use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class SchoolEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Add School';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'School Dashboard Management';

    /**
     * @var bool
     */
    public $exists = false;

    public $permission = 'admin.school';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(School $school): array
    {
        $this->exists = $school->exists;
        if ($this->exists) $this->name = 'Edit School';

        return [
            'school' => $school,
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
            Button::make('Save School')
                ->icon('save')
                ->type(Color::PRIMARY())
                ->method('createOrUpdate')
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
                    Picture::make('school.logo')
                        ->targetRelativeUrl()
                        ->title('Logo')
                        ->tabindex(1)
                        ->maxFileSize(1),

                    Input::make('school.name')
                        ->title('School Name')
                        ->tabindex(2)
                        ->required(),
                ]),
                Group::make([
                    Input::make('school.contact')
                        ->mask('9999999999')
                        ->title('Contact')
                        ->tabindex(3)
                        ->required(),
                    Input::make('school.email')
                        ->title('Email')
                        ->type('email')
                        ->tabindex(4)
                        ->required(),
                ]),
                Group::make([
                    Input::make('school.code')
                        ->title('School Code')
                        ->mask('aaa')
                        ->help('3 Characters unique school to be used in PRN and Receipts')
                        ->tabindex(5)
                        ->required(),
                    Input::make('school.academic_year_start')
                        ->title('Academic Year start (Ex. 01-06) Zero required')
                        ->mask('99-99'),
                    Input::make('school.academic_year_end')
                        ->mask('99-99')
                        ->title('Academic Year start (Ex. 31-05) Zero required'),
                ]),
                TextArea::make('school.address')
                    ->title('Address')
                    ->rows(2)
                    ->tabindex(6)
                    ->required(),
            ]),
        ];
    }

    /**
     * @param School    $school
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(School $school, Request $request): RedirectResponse
    {
        $form = $request->validate([
            'school.name' => 'required|max:191',
            'school.contact' => 'required|max:191',
            'school.email' => 'required|email|max:191',
            'school.address' => 'required|max:191',
            'school.logo' => 'required',
            'school.academic_year_start' => 'bail|required|regex:/[0-3]{1}[0-9]{1}-[0-1]{1}[1-9]{1}/',
            'school.academic_year_end' => 'bail|required|regex:/[0-3]{1}[0-9]{1}-[0-1]{1}[1-9]{1}/',
            'school.code' => [
                'bail',
                'required',
                Rule::unique('schools', 'code')->ignore($school->id),
            ],
        ])['school'];

        $form['login_url'] = Str::of($form['name'])
            ->slug()
            ->limit(191);

        $school->fill($form)->save();
        Toast::success('Added details successfully!');
        return redirect()->route('admin.school.list');
    }

    /**
     * @param School $school
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(School $school): RedirectResponse
    {
        $school->delete();

        Toast::info('You have successfully removed the school from records.');

        return redirect()->route('admin.school.list');
    }
}
