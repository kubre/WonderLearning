<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Division;
use App\Models\Homework;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Support\Facades\Toast;

class HomeworkEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Assign Homework';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Assign new homework to a division.';

    protected $hasAttachment = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(?Homework $homework): array
    {
        $homework->load('attachment');
        $this->hasAttachment = $homework->attachment->isNotEmpty();
        return $homework->toArray();
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save (Issue homework)')
                ->icon('save')
                ->type(Color::PRIMARY())
                ->method('save'),
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
                Input::make('title')
                    ->title('Title')
                    ->required()
                    ->maxlength(255),
                Select::make('division_id')
                    ->title('Division')
                    ->help('Given homework will be assigned to all the students in the division')
                    ->fromQuery(Division::when(
                        !auth()->user()->hasAccess('school.users'),
                        fn ($query) => $query->ofTeacher(auth()->id())
                    )->selectRaw("id, concat(title, ' (', program, ')') as name"), 'name')
                    ->required(),
                TextArea::make('body')
                    ->title('Homework')
                    ->rows(5)
                    ->required(),
                DateTimer::make('date_at')
                    ->title('Date')
                    ->format('Y-m-d')
                    ->required(),
                Upload::make('image')
                    ->groups('homework')
                    ->maxFiles(1)
                    ->storage('temp')
                    ->maxFileSize(1)
                    ->canSee(!$this->hasAttachment)
                    ->acceptedFiles('image/jpeg,image/png')
                    ->title('Attachment (optional image)')
                    ->help('Optional image')
            ]),
        ];
    }

    public function save(?Homework $homework, Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'division_id' => ['bail', 'required', 'exists:divisions,id'],
            'body' => ['required', 'max:500'],
        ]);
        $homework->fill($request->all())->save();
        $homework->attachment()->syncWithoutDetaching(
            $request->input('image', [])
        );
        Toast::info('Issued homework to all students under division successfully!');
        return \redirect()->route('teacher.homework');
    }
}
