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
        $options = ['teacher'];
        if (auth()->user()->inRole('school-owner')) {
            $options = [
                'teacher',
                'center-head',
                'school-owner',
            ];
        }
        return [
            Select::make('user.roles.')
                ->fromQuery(
                    Role::whereIn('slug', $options),
                    'name'
                )
                ->multiple()
                ->title(__('Name role'))
                ->help('Specify which groups this account should belong to'),
        ];
    }
}
