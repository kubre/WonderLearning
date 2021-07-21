<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Division;
use App\Models\Notice;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NoticeEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Issue Notice';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Once notice is issued it will be visible to all the parent under that division.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(?Notice $notice): array
    {
        return $notice->toArray();
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save the Album')
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
                    ->title('Notice Heading')
                    ->required(),
                Select::make('division_id')
                    ->title('Division')
                    ->empty('Select Division', 0)
                    ->fromQuery(Division::when(
                        !auth()->user()->hasAccess('school.users'),
                        fn ($query) => $query->ofTeacher(auth()->id())
                    )->selectRaw("id, concat(title, ' (', program, ')') as name"), 'name')
                    ->required(),
                Quill::make('body')
                    ->title('Notice')
                    ->toolbar(["text", "color", "header", "list", "format"]),
            ]),
        ];
    }

    public function save(?Notice $notice, Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:191',],
            'body' => ['nullable', ],
            'division_id' => ['bail', 'required', 'exists:divisions,id'],
        ]);
        $notice->fill($request->all())->save();
        Toast::info('Issued notice to all the parents successfully!');
        return \redirect()->route('teacher.notice');
    }
}
