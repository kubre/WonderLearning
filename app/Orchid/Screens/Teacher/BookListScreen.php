<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Syllabus;
use Orchid\Screen\Screen;

class BookListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Books';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Content of the selected book';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Syllabus $book): array
    {
        $this->name = $book->name;
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [];
    }
}
