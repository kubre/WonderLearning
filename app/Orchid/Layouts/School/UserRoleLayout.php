<?php

namespace App\Orchid\Layouts\School;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserRoleLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Select::make('user.roles.')
                ->fromQuery(Role::whereIn(
                    'slug',
                    [
                        'center-head',
                        'school-owner',
                        'teacher',
                    ]
                ), 'name')
                ->multiple()
                ->title(__('Name role'))
                ->help('Specify which groups this account should belong to'),
        ];
    }
}
