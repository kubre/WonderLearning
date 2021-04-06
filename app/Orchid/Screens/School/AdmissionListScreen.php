<?php

namespace App\Orchid\Screens\School;

use App\Models\Admission;
use App\Models\Fees;
use App\Orchid\Layouts\School\AdmissionListLayout;
use Orchid\Screen\Screen;

class AdmissionListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Manage Admission';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Manage current year\'s admissions.';

    /** @var array|string */
    public $permission = 'admission.table';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'admissions' => Admission::filters()->with(['student'])->paginate(),
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
            AdmissionListLayout::class
        ];
    }
}
