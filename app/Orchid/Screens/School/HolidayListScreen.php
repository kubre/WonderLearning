<?php

namespace App\Orchid\Screens\School;

use App\Models\Holiday;
use App\Orchid\Layouts\School\HolidayListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Card;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class HolidayListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Manage Holidays';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'See and manage current working year holidays.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $holidays = Holiday::filters()
            ->orderBy('start_at', 'DESC')
            ->simplePaginate(20);
        return \compact('holidays');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Add new Holiday')
                ->icon('plus')
                ->type(Color::PRIMARY())
                ->route('school.holiday.edit'),
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
            HolidayListLayout::class
        ];
    }

    public function remove(Holiday $holiday)
    {
        $holiday->delete();
        Toast::info('Removed holiday from records successfully!');
        return \redirect()->route('school.holiday');
    }
}
