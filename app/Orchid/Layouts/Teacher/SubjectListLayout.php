<?php

namespace App\Orchid\Layouts\Teacher;

use App\Models\Syllabus;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class SubjectListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'subjects';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Name')
                ->width(200),
            TD::make('program')
                ->width(100),
            TD::make('books', 'Books')
                ->render(
                    fn (Syllabus $subject) => '<div style="display: grid; grid-template-columns: auto auto; grid-row-gap: 10px; grid-column-gap: 10px">' .
                    ($this->getBookList($subject))
                    . '</div>'
                ),
        ];
    }

    public function getBookList($subject)
    {
        return $subject->children->map(fn (Syllabus $s) => '<a class=\'btn btn-danger\' href=\'' . route("teacher.subjects.book", ['syllabus' => $s->id ]) . '\'>' .
            $s->name
        . '</a>')->join('');
    }
}
