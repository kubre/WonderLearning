<?php

namespace App\Orchid\Layouts\Teacher;

use App\Models\Admission;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class ChatListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'students';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('prn', 'PRN')
                ->render(fn (Admission $a) => $a->student->prn),
            TD::make('student_name', 'Name')
                ->render(fn (Admission $a) => $a->student->name)
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('parent_name', 'Parents')
                ->filter(TD::FILTER_TEXT)
                ->render(fn (Admission $a) =>
                join('/', array_filter([$a->student->father_name, $a->student->mother_name]))),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Admission $a) {
                    return
                        Link::make('Go To Chat')
                        ->type(Color::INFO())
                        ->icon('cursor')
                        ->parameters([
                            'id' => $a->student->id,
                        ]);
                }),
        ];
    }
}
