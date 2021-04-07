<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\School;
use Carbon\Carbon;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Session;

class PlatformScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Dashboard';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Welcome User!';

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
        return [
            ModalToggle::make('Change Academic Year (' . get_academic_year_formatted(working_year()) . ')')
                ->modalTitle('Change Academic Year')
                ->icon('calendar')
                ->modal('changeWorkingYear')
                ->method('updateWorkingYear'),
            // Link::make('Website')
            //     ->href('http://orchid.software')
            //     ->icon('globe-alt'),

            // Link::make('Documentation')
            //     ->href('https://orchid.software/en/docs')
            //     ->icon('docs'),

            // Link::make('GitHub')
            //     ->href('https://github.com/orchidsoftware/platform')
            //     ->icon('social-github'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        $valid_years = collect(range(2020, date('Y')))->mapWithKeys(function ($y) {
            $d = Carbon::createFromDate($y, session('school')->start_month, 1);
            return [$d->toDateString() => get_academic_year_formatted(get_academic_year($d))];
        });


        return [
            Layout::modal('changeWorkingYear', [
                Layout::rows([
                    Select::make('workingYear')
                        ->options($valid_years)
                        ->title('Select the Academic Year'),
                ]),
            ])
                ->applyButton('Next')
                ->closeButton('Cancel')
            // Layout::view('platform::partials.welcome'),
        ];
    }

    public function updateWorkingYear()
    {
        $d = Carbon::parse(request('workingYear'));
        working_year($d);
        Toast::success("Changed academic year to {$d->format('M Y')} successfully!");
    }
}
