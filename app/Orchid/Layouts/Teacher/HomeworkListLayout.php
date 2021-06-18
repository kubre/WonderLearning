<?php

namespace App\Orchid\Layouts\Teacher;

use App\Models\Homework;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class HomeworkListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'homeworks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title'),
            TD::make('date_at', 'Date'),
            TD::make('division.title', 'Division'),
            TD::make('attachment')
                ->render(function ($homework) {
                    return "<img height='40' src='" . optional($homework->attachment->first())->url() . "'>";
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Homework $homework) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Edit')
                                ->route('teacher.homework.edit', $homework->id)
                                ->icon('note'),

                            Button::make('Remove')
                                ->icon('trash')
                                ->method('remove')
                                ->confirm("Once deleted this can not be restored are you sure?")
                                ->parameters([
                                    'id' => $homework->id,
                                ]),
                        ]);
                }),
        ];
    }
}
