<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Models\School;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Relation::make('user.school_id')
                ->fromModel(School::class, 'name')
                ->title('Assign School')
                ->canSee(
                    auth()->user()->hasAccess('admin.school')
                ),
            CheckBox::make('user.is_center_head')
                ->title('Center Head')
                ->placeholder('Only one person can be Center Head.')
                ->sendTrueOrFalse(),
        ];
    }
}
