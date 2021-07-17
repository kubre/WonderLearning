<?php

namespace App\Orchid\Screens\School;

use App\Models\Division;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class GalleryEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Add Collection';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Add/Edit an album to the galley';

    public $hasAttachments = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(?Gallery $gallery): array
    {
        $gallery->load('attachment');
        $this->hasAttachments = $gallery->attachment->isNotEmpty();
        return $gallery->toArray();
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
                    ->title('Album Title')
                    ->required(),
                DateTimer::make('date_at')
                    ->format('Y-m-d')
                    ->title('Album Date'),
                Select::make('division_id')
                    ->title('Division')
                    ->help('Album will be visible to all the students in the division through the app.')
                    ->fromQuery(Division::selectRaw("id, concat(title, ' (', program, ')') as name"), 'name')
                    ->required(),
                Upload::make('pictures')
                    ->title('Pictures')
                    ->groups('album')
                    ->storage('temp')
                    ->acceptedFiles('image/*')
                    ->parallelUploads(2)
                    ->maxFiles(15)
                    ->maxFileSize(3)
                    ->canSee(!$this->hasAttachments)
                    ->help('Only maximum 15 files 2MB each is allowed.'),
            ])
        ];
    }


    public function save(?Gallery $album, Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:191',],
            'date_at' => ['nullable', 'date',],
            'division_id' => ['bail', 'required', 'exists:divisions,id'],
        ]);
        $album->fill($request->all())->save();
        $album->attachment()->syncWithoutDetaching(
            $request->input('pictures', [])
        );
        Toast::info('Saved the album to gallery successfully!');
        return \redirect()->route('school.gallery');
    }
}
