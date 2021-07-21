<?php

namespace App\Orchid\Layouts\Teacher;

use App\Models\Notice;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NoticeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'notices';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title')->filter(TD::FILTER_TEXT),
            TD::make('division.title', 'Issued For'),
            TD::make('user.name', 'Issued By'),
            TD::make('date_at', 'Issued On'),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Notice $notice) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Edit')
                                ->route('teacher.notice.edit', $notice->id)
                                ->icon('note'),

                            Button::make('Remove')
                                ->icon('trash')
                                ->method('remove')
                                ->confirm("Once deleted this can not be restored are you sure?")
                                ->parameters([
                                    'id' => $notice->id,
                                ]),
                        ]);
                }),
        ];
    }
}
