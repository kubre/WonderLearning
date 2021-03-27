<?php

namespace App\Orchid\Screens\School;

use App\Models\School;
use App\Models\User;
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
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->icon('trash')
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
                Input::make('school.name')
                    ->title('School Name')
                    ->required(),
                Picture::make('school.logo')
                    ->targetRelativeUrl()
                    ->title('Logo')
                    ->maxFileSize(1),
                Input::make('school.contact')
                    ->mask('9999999999')
                    ->title('Contact')
                    ->required(),
                Input::make('school.email')
                    ->title('Email')
                    ->type('email')
                    ->required(),
                TextArea::make('school.address')
                    ->title('Address')
                    ->rows(2)
                    ->required(),
                Relation::make('school.owner_id')
                    ->title('Owner')
                    ->fromModel(User::class, 'name')
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
    public function createOrUpdate(School $school, Request $request)
    {
        $form = $request->validate([
            'school.name' => 'required',
            'school.contact' => 'required',
            'school.email' => 'required|email',
            'school.address' => 'required',
            'school.logo' => 'required',
            'school.owner_id' => ['required',],
        ])['school'];
        $form['login_url'] = Str::slug($form['name']);
        
        $school->fill($form)->save();
        Alert::success(($this->exists ? 'Updated' : 'Added').' details successfully!');
        return redirect()->route('admin.school.list');
    }

    /**
     * @param School $school
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(School $school)
    {
        $school->delete();

        Alert::info('You have successfully deleted the school.');

        return redirect()->route('admin.school.list');
    }
}
