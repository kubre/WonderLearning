<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Admission;
use App\Models\Student;
use App\Models\Message;
use App\Exports\ChatExport;
use App\Orchid\Layouts\Teacher\ChatListLayout;
use App\Orchid\Layouts\Teacher\ProgramSelectionLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Maatwebsite\Excel\Facades\Excel;

class ChatListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Chats';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'See chats from all the parents in current year here.';

    public $permission = 'menu.report';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'students' => Admission::query()
                ->filters()
                ->filtersApplySelection(ProgramSelectionLayout::class)
                ->when(auth()->user()->inRole('teacher'), function ($query) {
                    $divisions = auth()->user()->divisions->pluck('id')->toArray();
                    return $query->whereIn('division_id', $divisions);
                })
                ->with(['student.school', 'division'])
                ->paginate(15),
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
            ProgramSelectionLayout::class,
            ChatListLayout::class,
        ];
    }
    
    public function exportChat($id)
    {
        return Excel::download(
            new ChatExport($id),
            'Chat_Export_' . $id . '_' . now()->toDateTimeString() . '.xlsx'
        );
    }
}
