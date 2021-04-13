<?php

namespace App\Orchid\Screens\Student;

use App\Models\Admission;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class InvoicePrintScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Print Invoice';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Print invoice details';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Admission $admission, string $parent): array
    {
        return compact('admission', 'parent');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Back')
                ->icon('arrow-left')
                ->route('school.admission.list'),
            Link::make('Print')
                ->icon('printer')
                ->type(Color::WARNING())
                ->href('javascript:(function(){window.print();})()'),
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
            Layout::view('reports.fees-invoice'),
        ];
    }
}
