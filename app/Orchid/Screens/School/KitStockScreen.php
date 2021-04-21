<?php

namespace App\Orchid\Screens\School;

use App\Models\KitStock;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class KitStockScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Kit Stock';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Manage the stock for kit';

    public $permission = 'school.users';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return
            KitStock::selectRaw(
                'playgroup_total, playgroup_assigned, (playgroup_total - playgroup_assigned) as playgroup_current, nursery_total, nursery_assigned, (nursery_total - nursery_assigned) as nursery_current, junior_kg_total, junior_kg_assigned, (junior_kg_total - junior_kg_assigned) as junior_kg_current, senior_kg_total, senior_kg_assigned, (senior_kg_total - senior_kg_assigned) as senior_kg_current'
            )
            ->firstOrNew()
            ->toArray();
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
                ->method('save')
                ->type(Color::PRIMARY())
                ->icon('save'),
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
                    Label::make('title')
                        ->title('Programme'),
                    Label::make('title')
                        ->class('text-center font-weight-bold')
                        ->value('Total'),
                    Label::make('title')
                        ->class('text-center font-weight-bold')
                        ->value('Assigned'),
                    Label::make('title')
                        ->class('text-center font-weight-bold')
                        ->value('Remaining'),
                ]),
                Group::make([
                    Label::make('title')
                        ->title('Playgroup'),
                    Input::make('playgroup_total')
                        ->type('number'),
                    Label::make('playgroup_assigned')
                        ->class('text-center'),
                    Label::make('playgroup_current')
                        ->class('text-center'),
                ]),
                Group::make([
                    Label::make('title')
                        ->title('Nursery'),
                    Input::make('nursery_total')
                        ->type('number'),
                    Label::make('nursery_assigned')
                        ->class('text-center'),
                    Label::make('nursery_current')
                        ->class('text-center'),
                ]),
                Group::make([
                    Label::make('title')
                        ->title('Junior KG'),
                    Input::make('junior_kg_total')
                        ->type('number'),
                    Label::make('junior_kg_assigned')
                        ->class('text-center'),
                    Label::make('junior_kg_current')
                        ->class('text-center'),
                ]),
                Group::make([
                    Label::make('title')
                        ->title('Senior KG'),
                    Input::make('senior_kg_total')
                        ->type('number'),
                    Label::make('senior_kg_assigned')
                        ->class('text-center'),
                    Label::make('senior_kg_current')
                        ->class('text-center'),
                ]),
            ])
        ];
    }

    public function save(Request $request)
    {
        $request->validate([
            'playgroup_total' => ['required', 'numeric'],
            'nursery_total' => ['required', 'numeric'],
            'junior_kg_total' => ['required', 'numeric'],
            'senior_kg_total' => ['required', 'numeric'],
        ]);

        KitStock::firstOrNew()
            ->fill($request->input())
            ->save();

        Toast::info('Updated stock successfully!');
        return redirect()->route('school.kit.stock');
    }
}
