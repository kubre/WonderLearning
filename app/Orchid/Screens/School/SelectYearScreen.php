<?php

namespace App\Orchid\Screens\School;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SelectYearScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Select Year';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Please select your Academic Year before proceeding!';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
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
        $validYears = collect(range(2020, date('Y')))->mapWithKeys(function ($y) {
            $d = Carbon::createFromDate($y, school()->start_month, 1);
            return [$d->toDateString() => get_academic_year_formatted(get_academic_year($d))];
        });
        return [
            Layout::view('layouts.sidebar-hide'),
            Layout::block([
                Layout::rows([
                    Select::make('workingYear')
                        ->options($validYears)
                        ->title('Select the Academic Year'),
                ]),
            ])
                ->title(__('Academic Year Selection'))
                ->description(__('To see data related particular academic year manage please select year to proceed. Current "Running Year" will be selected if not saved.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY())
                        ->icon('check')
                        ->method('updateWorkingYear')
                )
        ];
    }

    public function updateWorkingYear(Request $request)
    {
        $date = Carbon::parse($request->workingYear);
        working_year($date);
        Toast::success("Year set to {$date->format('M Y')} successfully!");
        return redirect()->route('platform.main');
    }
}
