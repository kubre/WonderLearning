<?php

namespace App\Orchid\Layouts\Admin;

use App\Models\ProgramSubject;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProgramSubjectsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'program_subjects';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('program', 'Programme'),
            TD::make('subject.name', 'Subject'),
            TD::make('action', 'Action')
                ->render(
                    fn (ProgramSubject $association) =>
                    Button::make('Delete')
                        ->icon('trash')
                        ->method('remove')
                        ->confirm("Once deleted this can not be restored are you sure?")
                        ->parameters([
                            'id' => $association->syllabus_id,
                        ])
                ),
        ];
    }
}
