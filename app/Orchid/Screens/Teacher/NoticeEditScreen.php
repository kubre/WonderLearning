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
                    ->multiple()
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
            'division_id' => ['bail', 'required', 'array'],
        ]);
        $title = $request->title;
        $body = $request->body;
        $user_id = auth()->id();
        $date_at = now();
        $school_id = school()->id;
        $created_at = working_year()[0];
        $data = collect($request->division_id)->filter(function ($division_id) {
            return (int) $division_id !== 0;
        })->map(function ($division_id) 
            use ($title, $body, $user_id, $date_at, $school_id, $created_at) {
            return [
                'title' => $title,
                'body' => $body,
                'division_id' => (int) $division_id,
                'user_id' => $user_id,
                'date_at' => $date_at,
                'school_id' => $school_id,
                'created_at' => $created_at,
                'updated_at' => $date_at,
            ];
        })->toArray();
        Notice::insert($data);
        Toast::info('Issued notice to all the parents successfully!');
        return \redirect()->route('teacher.notice');
    }
}
