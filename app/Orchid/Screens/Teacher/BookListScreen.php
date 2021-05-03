<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Syllabus;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;

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

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Syllabus $book): array
    {
        $this->name = $book->name;
        return [
            'items' => $book->descendants()->with('children')->get(),
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

    public function markComplete(Syllabus $book, Request $request)
    {
        $request->validate([
            'syllabus_id' => ['bail', 'required', 'exists:syllabi,id',],
            'completed_at' => ['required', 'date'],
        ]);

        return response(['status' => 'ok']);
    }
}
