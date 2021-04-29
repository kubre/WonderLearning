<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Admission;
use App\Models\Fees;
use App\Orchid\Layouts\Account\ProgramSelectionLayout;
use App\Orchid\Layouts\School\AdmissionListLayout;
use Orchid\Screen\Screen;

class StudentListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Students';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'See all the students assigned under you across all divisions and programmes.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $divisions = auth()->user()->divisions->pluck('id')->toArray();
        return [
            'admissions' => Admission::query()
                ->filters()
                ->filtersApplySelection(ProgramSelectionLayout::class)
                ->whereIn('division_id', $divisions)
                ->with(['student.school', 'division'])
                ->simplePaginate(30),
            'fees' => Fees::first(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            ProgramSelectionLayout::class,
            AdmissionListLayout::class,
        ];
    }
}
