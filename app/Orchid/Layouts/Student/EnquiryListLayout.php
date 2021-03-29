<?php

namespace App\Orchid\Layouts\Student;

use App\Models\Enquiry;
use App\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
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

    protected User $user;

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        $this->user = auth()->user();
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
                ->canSee($this->user->hasAccess('enquiry.edit') ||
                    $this->user->hasAccess('enquiry.delete') ||
                    $this->user->hasAccess('admission.create'))
                ->render(function (Enquiry $enquiry) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('school.enquiry.edit', $enquiry->id)
                                ->canSee($this->user->hasAccess('enquiry.edit'))
                                ->icon('note'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->canSee($this->user->hasAccess('enquiry.delete'))
                                ->method('remove')
                                ->confirm("Once deleted this can not be restored are you sure?")
                                ->parameters([
                                    'id' => $enquiry->id,
                                ]),
                            ModalToggle::make(__('Convert to Admission'))
                                ->icon('share-alt')
                                ->canSee($this->user->hasAccess('admission.create'))
                                ->modal('chooseEnquirerType')
                                ->modalTitle('Admission Process #1')
                                ->method('proceedToAdmission')
                                ->asyncParameters($enquiry->id),
                        ]);
                }),
        ];
    }
}
