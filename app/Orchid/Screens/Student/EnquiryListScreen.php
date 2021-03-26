<?php

namespace App\Orchid\Screens\Student;

use App\Models\Enquiry;
use App\Orchid\Layouts\Student\EnquiryListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
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

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'enquiries' => Enquiry::paginate(),
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
            Link::make('New Enquiry')
                ->type(Color::PRIMARY())
                ->route('school.enquiry.edit')
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
            EnquiryListLayout::class
        ];
    }

    /**
     * @param Enquiry $enquiry
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Enquiry $enquiry)
    {
        $enquiry->delete();

        Toast::info('You have successfully deleted the enquiry.');

        return redirect()->route('school.enquiry.list');
    }
}
