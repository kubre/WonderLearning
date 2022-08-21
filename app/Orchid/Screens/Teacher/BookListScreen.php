<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Approval;
use App\Models\SchoolSyllabus;
use App\Models\Syllabus;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public $description = 'Index Page';

    public $permission = 'teacher.subjects';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Syllabus $book): array
    {
        $this->name = $book->name;
        $items = $book->descendants()
            ->with('children', 'covered')
            ->get();
        return [
            'items' => $items,
            'book_id' => $book->id,
        ];
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
            Layout::view('components.book'),
        ];
    }

    public function markComplete(int $bookId, Request $request)
    {
        $request->validate([
            'teacher_name' => ['required'],
            'school_id' => ['required'],
            'completed_at' => ['required', 'date'],
            'syllabus_id' => ['bail', 'required', 'exists:syllabi,id',],
        ]);

        DB::transaction(function () use ($request) {
            Approval::create([
                'school_id' => $request->school_id,
                'method' => 'markSyllabus',
                'approval_type' => Syllabus::class,
                'approval_id' => $request->syllabus_id,
                'data' => [
                    'completed_at' => $request->completed_at,
                    'teacher_name' => $request->teacher_name,
                ],
                'created_at' => working_year()[0],
            ]);

            SchoolSyllabus::updateOrCreate([
                'school_id' => $request->school_id,
                'syllabus_id' => $request->syllabus_id,
            ]);
        });

        return response(['status' => 'ok']);
    }
}
