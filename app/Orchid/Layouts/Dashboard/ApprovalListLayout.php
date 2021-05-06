<?php

namespace App\Orchid\Layouts\Dashboard;

use App\Models\Approval;
use App\Models\Receipt;
use App\Models\SchoolSyllabus;
use App\Services\ApprovalService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

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
            TD::make('for', 'Approval for')
                ->render(fn (Approval $approval)
                => ApprovalService::messageFor($approval)),
            TD::make('actions', 'Actions')
                ->render(
                    fn (Approval $approval) =>
                    Group::make([
                        Button::make('Approve')
                            ->icon('check')
                            ->method('approve')
                            ->type(Color::PRIMARY())
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
                    ])
                        ->autoWidth()
                ),
        ];
    }
}
