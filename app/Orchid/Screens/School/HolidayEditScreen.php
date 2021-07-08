<?php

namespace App\Orchid\Screens\School;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class HolidayEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Add Holiday';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Add a new holiday.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(?Holiday $holiday): array
    {
        if ($holiday->exists) {
            $this->name = 'Edit Holiday';
            $this->description = 'Edit details for ' . $holiday->title;
        }
        return $holiday->toArray();
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save')
                ->icon('save')
                ->type(Color::PRIMARY())
                ->method('save'),
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
                Input::make('title')
                    ->title('Title')
                    ->required()
                    ->maxlength(255),
                TextArea::make('notice')
                    ->title('Notice')
                    ->rows(3)
                    ->maxlength(500),
                DateTimer::make('start_at')
                    ->title('Date (Start Date)')
                    ->format('Y-m-d')
                    ->required(),
                DateTimer::make('end_at')
                    ->title('End Date')
                    ->format('Y-m-d')
                    ->help('Note: Leave this field empty to make it single day holiday.'),
            ]),
        ];
    }

    public function save(?Holiday $holiday, Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:191'],
            'notice' => ['nullable', 'max:500'],
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'end_at' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $holiday->fill($request->all())->save();

        Toast::info('Holiday added successfully!');
        return \redirect()->route('school.holiday');
    }
}
