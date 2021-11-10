<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Admission;
use App\Models\Student;
use App\Orchid\Layouts\Teacher\ChatListLayout;
use App\Orchid\Layouts\Teacher\ProgramSelectionLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

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

    public $permission = 'teacher.student';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $divisions = auth()->user()->divisions->pluck('id')->toArray();
        return [
            'students' => Admission::query()
                ->filters()
                ->filtersApplySelection(ProgramSelectionLayout::class)
                ->whereIn('division_id', $divisions)
                ->with(['student.school', 'division'])
                ->simplePaginate(15),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('New Chat'))
                ->icon('plus')
                ->href(route('platform.systems.roles.create')),
        ];
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
}
