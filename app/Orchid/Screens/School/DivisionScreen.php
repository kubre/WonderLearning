<?php

namespace App\Orchid\Screens\School;

use App\Models\Division;
use App\Models\School;
use App\Models\User;
use App\Orchid\Layouts\School\DivisionListLayout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class DivisionScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Division';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Manage Division and assign to teachers';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'divisions' => Division::with('teacher')
                ->simplePaginate(20),
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
            ModalToggle::make('Add Division')
                ->icon('plus')
                ->modal('addDivision')
                ->type(Color::PRIMARY())
                ->modalTitle('Add Division & Assign to Teacher')
                ->method('add'),
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
            Layout::modal('addDivision', [
                Layout::rows([
                    Input::make('title')
                        ->title('Division Name')
                        ->required(),
                    Select::make('program')
                        ->options(School::PROGRAMMES)
                        ->title('Program')
                        ->required(),
                    Relation::make('teacher_id')
                        ->title('Teacher')
                        ->fromModel(User::class, 'name')
                        ->applyScope('ofSchool', school()->id)
                        ->required(),
                ]),
            ])->applyButton('Save'),
            DivisionListLayout::class,
        ];
    }

    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'program' => ['required', 'in:' . \implode(',', School::PROGRAMMES)],
            'teacher_id' => 'required|exists:users,id'
        ]);

        Division::create($request->input());

        Toast::info('Created and Assigned the division to the teacher.');

        return redirect()->route('school.divisions');
    }

    public function remove(Division $division)
    {
        $division->delete();

        Toast::info('Removed division and unassigned the teacher.');

        return redirect()->route('school.divisions');
    }
}
