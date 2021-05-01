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
            TD::make('name', 'Name'),
            TD::make('books', 'Books')
                ->render(
                    fn (Syllabus $s) => Group::make(
                        $s->children->map(fn (Syllabus $s) =>
                        Link::make($s->name)
                            ->icon('book-open')
                            ->type(Color::ERROR())
                            ->route('teacher.subjects.book', ['syllabus' => $s->id]))
                            ->toArray()
                    )->autoWidth()
                ),
        ];
    }
}
