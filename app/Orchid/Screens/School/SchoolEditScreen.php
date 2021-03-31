<?php

namespace App\Orchid\Screens\School;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Str;
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
                TextArea::make('school.address')
                    ->title('Address')
                    ->rows(2)
                    ->tabindex(5)
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
            'school.name' => 'required',
            'school.contact' => 'required',
            'school.email' => 'required|email',
            'school.address' => 'required',
            'school.logo' => 'required',
        ])['school'];
        $form['login_url'] = Str::slug($form['name']);

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

        Toast::info('You have successfully deleted the school.');

        return redirect()->route('admin.school.list');
    }
}
