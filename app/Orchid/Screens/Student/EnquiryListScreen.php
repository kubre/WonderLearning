<?php

namespace App\Orchid\Screens\Student;

use App\Models\Enquiry;
use App\Models\User;
use App\Orchid\Layouts\Student\EnquiryListLayout;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EnquiryListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Enquiry Management';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Add, Edit, Delete, Convert to Admission the enquiries and more.';

    /** @var array|string */
    public $permission = 'enquiry.table';

    protected User $user;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $this->user = auth()->user();

        return [
            'enquiries' => Enquiry::filters()
                ->simplePaginate(),
            'count' => Enquiry::select('program', DB::raw('COUNT(id) as count'))
                ->groupBy('program')
                ->get()
                ->mapWithKeys(fn ($item) => [$item->program => $item->count])
                ->toArray(),
            'route' => 'school.enquiry.list',
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
            Link::make('Add Enquiry')
                ->type(Color::PRIMARY())
                ->route('school.enquiry.edit')
                ->canSee($this->user->hasAccess('enquiry.create'))
                ->icon('plus'),
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
            Layout::modal('chooseEnquirerType', [
                Layout::rows([
                    Select::make('enquirer')
                        ->options([
                            'other' => 'Other',
                            'father' => 'Father',
                            'mother' => 'Mother',
                        ])->title('Map the enquirer details to'),
                ]),
            ])
                ->applyButton('Next')
                ->closeButton('Cancel'),
            Layout::view('layouts.program-filter'),
            EnquiryListLayout::class
        ];
    }

    /**
     * @param Enquiry $enquiry
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Enquiry $enquiry): \Illuminate\Http\RedirectResponse
    {
        $enquiry->delete();

        Toast::info('You have successfully deleted the enquiry.');

        return redirect()->route('school.enquiry.list');
    }

    public function proceedToAdmission($enquirerId)
    {
        return redirect()->route(
            'school.admission.edit',
            ['enquirerId' => $enquirerId, 'enquirer' => request('enquirer')]
        );
    }
}
