<?php

namespace App\Orchid\Layouts\Student;

use App\Models\Enquiry;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class EnquiryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'enquiries';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            // TD::make('id'),
            TD::make('created_at', 'Enquiry Date')
                ->filter(TD::FILTER_DATE)
                ->render(fn ($e) => $e->created_at->format('d-m-Y'))
                ->sort(),
            TD::make('name', 'Name')->filter(TD::FILTER_TEXT),
            TD::make('enquirer_contact', 'Contact'),
            TD::make('follow_up_at', 'Follow Up Date')
                ->filter(TD::FILTER_DATE)
                ->render(fn ($e) => $e->follow_up_at->format('d-m-Y')),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Enquiry $enquiry) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('school.enquiry.edit', $enquiry->id)
                                ->icon('note'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->method('remove')
                                ->confirm("Once deleted this can not be restored are you sure?")
                                ->parameters([
                                    'id' => $enquiry->id,
                                ]),
                        ]);
                }),
        ];
    }
}
