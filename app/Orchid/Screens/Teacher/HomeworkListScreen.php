<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Homework;
use App\Orchid\Layouts\School\DivisionSelectionLayout;
use App\Orchid\Layouts\Teacher\HomeworkListLayout;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class HomeworkListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Homework List';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Assign homework to a division on daily basis.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'homeworks' => Homework::with('division', 'attachment')
                ->filters()
                ->filtersApplySelection(DivisionSelectionLayout::class)
                ->simplePaginate(30),
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
            Link::make('Assign Homework')
                ->icon('plus')
                ->type(Color::PRIMARY())
                ->route('teacher.homework.edit'),
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
            DivisionSelectionLayout::class,
            HomeworkListLayout::class,
        ];
    }

    public function remove(Homework $homework)
    {
        optional($homework->attachment()->first())->delete();
        $homework->delete();
        Toast::info('Removed homework from records successfully!');
        return \redirect()->route('teacher.homework');
    }
}
