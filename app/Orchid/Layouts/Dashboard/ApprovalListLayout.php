<?php

namespace App\Orchid\Layouts\Dashboard;

use App\Models\Approval;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ApprovalListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'approvals';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('for', 'Approval for Deletion')
                ->render(fn () => 'Approval for Deletion'),
            TD::make('receipt_no', 'Receipt No')
                ->render(fn (Approval $a) => $a->approval->receipt_no),
            TD::make('receipt_no', 'Receipt Amount')
                ->render(fn (Approval $a) => $a->approval->amount),
            TD::make('name', 'Student Name')
                ->render(fn (Approval $a) => $a->approval->admission->student->name),
            TD::make('actions', 'Actions')
                ->render(fn (Approval $approval) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Button::make('Approve')
                            ->icon('check')
                            ->method('approve')
                            ->confirm('Are you sure?')
                            ->parameters([
                                'id' => $approval->id,
                            ]),
                        Button::make('Cancel')
                            ->icon('close')
                            ->method('cancel')
                            ->parameters([
                                'id' => $approval->id,
                            ]),
                    ])),
        ];
    }
}
