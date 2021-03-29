<?php

namespace App\Orchid\Screens\School;

use App\Models\School;
use App\Orchid\Layouts\School\SchoolListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class SchoolListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Schools';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Manage School Data';

    /** @var string|array */
    public $permission = 'admin.school';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'schools' => School::paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create School')
                ->route('admin.school.edit')
                ->icon('pencil'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            SchoolListLayout::class
        ];
    }
}
