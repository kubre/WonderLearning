<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\ProgramSubject;
use App\Models\Syllabus;
use App\Orchid\Layouts\Teacher\SubjectListLayout;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;

class SubjectListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Subjects';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'List of all the subjects under you.';

    public $permission = 'teacher.subjects';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $subjects = Syllabus::subjectsForTeacher(auth()->id())
            ->with('children')
            ->simplePaginate();
        return compact('subjects');
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
        return [
            SubjectListLayout::class,
        ];
    }
}
