<?php

namespace App\Orchid\Screens;

use App\Models\Admission;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;

class DeclarationFormScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Declaration Form';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Declaration Form';

    public string $fileName = 'declaration_';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Admission $admission): array
    {
        $parent = request()->query('parent') ?? $this->getGuardianOfParent($admission);
        $this->fileName .= $admission->student->name . '_' . $admission->invoice_no;

        $monthList = [];

        list($start, $end) = working_year();
        $startMonth = $start->copy();
        $endMonth = $end->copy();

        for ($i = $startMonth; $i <= $endMonth; $i->addMonth()) {
            $monthList[(int)$i->format('m')] = $i->format('M Y');
        }

        return compact('admission', 'parent', 'monthList');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Print')
                ->icon('printer')
                ->type(Color::WARNING())
                ->href("javascript:printReport('{$this->fileName}', '" . env('APP_URL') . "')"),
            Link::make('Save and Proceed')
                ->icon('check')
                ->type(Color::PRIMARY())
                ->route('school.admission.list'),
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
            Layout::rows([
                Group::make([
                    Select::make('parent')
                        ->title('Guardian details')
                        ->horizontal()
                        ->options([
                            'father' => 'Father',
                            'mother' => 'Mother',
                        ]),
                    Button::make('Refresh')
                        ->type(Color::PRIMARY())
                        ->method('changeGuardian')
                        ->icon('refresh'),
                ])
            ]),
            Layout::view('reports.declaration'),
        ];
    }

    protected function getGuardianOfParent(Admission $admission)
    {
        if ($admission->student->father_name) {
            return 'father';
        }
        return 'mother';
    }

    public function changeGuardian(Admission $admission, Request $request)
    {
        return redirect()->route('reports.declaration.form', [
            'admission' => $admission,
            'parent' => $request->parent,
        ]);
    }
}
