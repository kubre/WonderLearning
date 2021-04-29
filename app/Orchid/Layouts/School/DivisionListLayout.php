<?php

namespace App\Orchid\Layouts\School;

use App\Models\Division;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DivisionListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'divisions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title'),
            TD::make('program'),
            TD::make('teacher.name', 'Teacher Assigned'),
            TD::make('action', 'Action')
                ->render(
                    fn (Division $division) =>
                    Button::make('Delete')
                        ->icon('trash')
                        ->method('remove')
                        ->confirm("Once deleted this can not be restored are you sure?")
                        ->parameters([
                            'id' => $division->id,
                        ])
                ),
        ];
    }
}
