<?php

namespace App\Orchid\Layouts;

use App\Models\School;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class ExportListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'model'
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncUpdatedModel';

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [
            Layout::rows([
                Select::make('model')
                    ->title('Data Model')
                    ->options([
                        'users' => 'Users',
                        'schools' => 'Schools',
                        'enquiries' => 'Enquiries',
                        'admissions' => 'Student Data with Photos',
                        'fees' => 'School Fees',
                        'receipts' => 'Receipts',
                        'kits' => 'Kit Stocks',
                    ]),
                Relation::make('school_id')
                ->fromModel(School::class, 'name')
                ->title('Select School')
                ->help('Note: You can leave this empty to download all student data.')
                ->canSee($this->query->get('model') === 'admissions'),
            ]),
        ];
    }
}
