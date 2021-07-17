<?php

namespace App\Orchid\Screens\School;

use App\Models\Gallery;
use App\Orchid\Layouts\School\DivisionSelectionLayout;
use App\Orchid\Layouts\School\GalleryListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class GalleryListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Gallery';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Warning: Images will only retained for 15 days maximum. This gallery is only to share pictures with parents.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'albums' => Gallery::with('division')
                ->withCount('attachment')
                ->filters()
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
            Link::make('New Album')
                ->icon('plus')
                ->type(Color::PRIMARY())
                ->route('school.gallery.edit'),
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
            GalleryListLayout::class,
        ];
    }
}
