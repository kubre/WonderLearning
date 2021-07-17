<?php

namespace App\Orchid\Layouts\School;

use App\Models\Gallery;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class GalleryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'albums';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', 'Album Title')
                ->filter(TD::FILTER_TEXT),
            TD::make('date_at', 'Album Date')
                ->filter(TD::FILTER_DATE),
            TD::make('attachment_count', 'Pictuers'),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Gallery $album) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Edit')
                                ->route('school.gallery.edit', $album->id)
                                ->icon('note'),

                            Button::make('Remove')
                                ->icon('trash')
                                ->method('remove')
                                ->confirm("Once deleted this can not be restored are you sure?")
                                ->parameters([
                                    'id' => $album->id,
                                ]),
                        ]);
                }),
        ];
    }
}
