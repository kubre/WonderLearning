<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Student;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ChatUIScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Chat with ';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = '';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Student $student): array
    {
        $this->name .= $student->name . ' Parents';
        return [
            'student' => $student,
            'teacher' => auth()->user(),
            'from_date' => working_year()[0],
            'to_date' => working_year()[1],
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
            Layout::view('components.chat'),
        ];
    }
}
