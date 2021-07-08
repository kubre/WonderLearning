<?php

namespace App\Orchid\Layouts\School;

use App\Models\Holiday;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class HolidayListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'holidays';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title'),
            TD::make('notice'),
            TD::make('start_at', 'Date (Start Date)')
                ->render(fn (Holiday $holiday) => $holiday->start_at->format('d-M-Y')),
            TD::make('end_at', 'End Date')
                ->render(fn (Holiday $holiday) => optional($holiday->end_at)->format('d-M-Y') ?? 'No Date'),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Holiday $holiday) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Edit')
                                ->route('school.holiday.edit', $holiday->id)
                                ->icon('note'),

                            Button::make('Remove')
                                ->icon('trash')
                                ->method('remove')
                                ->confirm("Once deleted this can not be restored are you sure?")
                                ->parameters([
                                    'id' => $holiday->id,
                                ]),
                        ]);
                }),
        ];
    }
}
