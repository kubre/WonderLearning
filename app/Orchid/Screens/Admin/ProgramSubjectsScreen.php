<?php

namespace App\Orchid\Screens\Admin;

use App\Models\ProgramSubject;
use App\Models\School;
use App\Models\Syllabus;
use App\Orchid\Layouts\Admin\ProgramSubjectsListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class ProgramSubjectsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Add Subjects to Programme';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Associate which subjects belong to which program.';

    public $permission = 'admin.user';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'program_subjects' => ProgramSubject::with('subject')->simplePaginate(30),
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
            ModalToggle::make('Add')
                ->icon('plus')
                ->modal('addSubjectToProgramme')
                ->type(Color::PRIMARY())
                ->modalTitle('Associate a subject to a programme')
                ->method('associate'),
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
            Layout::modal('addSubjectToProgramme', [
                Layout::rows([
                    Select::make('program')
                        ->options(School::PROGRAMMES)
                        ->title('Program')
                        ->required(),
                    Select::make('syllabus_id')
                        ->title('Subject')
                        ->fromQuery(Syllabus::unassignedSubjects(), 'name')
                        ->required(),
                ]),
            ])->applyButton('Save'),
            ProgramSubjectsListLayout::class,
        ];
    }

    public function associate(Request $request): RedirectResponse
    {
        $request->validate([
            'program' => ['required', 'in:' . \implode(',', School::PROGRAMMES)],
            'syllabus_id' => 'required|exists:syllabi,id'
        ]);

        ProgramSubject::create($request->input());

        Toast::info('Added the subject under programme.');

        return redirect()->route('admin.program-subjects');
    }

    public function remove(ProgramSubject $association): RedirectResponse
    {
        $association->delete();

        Toast::info('Removed subject from programme.');

        return redirect()->route('admin.program-subjects');
    }
}
