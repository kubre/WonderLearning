<?php

namespace App\Orchid\Layouts\School;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class DivisionRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Select::make('division_id')
                ->options($this->query->get('divisions') ?? [])
                ->title('Division'),
        ];
    }
}
