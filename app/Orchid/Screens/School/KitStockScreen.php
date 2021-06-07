<?php

namespace App\Orchid\Screens\School;

use App\Models\KitStock;
use App\Models\KitStockLog;
use App\Orchid\Layouts\School\KitStockLogListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
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

    public const PROGRAMS = [
        'playgroup_total' => 'Playgroup',
        'nursery_total' => 'Nursery',
        'junior_kg_total' => 'Junior KG',
        'senior_kg_total' => 'Senior KG',
    ];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $stock = KitStock::select('id')
            ->selectRaw(
                'playgroup_total, playgroup_assigned, (playgroup_total - playgroup_assigned) as playgroup_current, nursery_total, nursery_assigned, (nursery_total - nursery_assigned) as nursery_current, junior_kg_total, junior_kg_assigned, (junior_kg_total - junior_kg_assigned) as junior_kg_current, senior_kg_total, senior_kg_assigned, (senior_kg_total - senior_kg_assigned) as senior_kg_current'
            )
            ->firstOrNew()
            ->toArray();
        $stock['logs'] = [];
        if (isset($stock['id'])) {
            $stock['logs'] = KitStockLog::where('kit_stock_id', $stock['id'])
                ->paginate();
        }
        return $stock;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make('Add Stock')
                ->modal('addStock')
                ->modalTitle('Add new stock for kit')
                ->type(Color::PRIMARY())
                ->method('add')
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
            Layout::modal('addStock', Layout::rows([
                Select::make('program')
                    ->options(static::PROGRAMS)
                    ->required()
                    ->title('Programme'),
                Input::make('quantity')
                    ->title('Quantity to new stock')
                    ->type('numeric')
                    ->help('Ex: if you add 10 new quantity to playgroup if you already had 20, Now you will have 30 in total.')
                    ->required(),
                Label::make('warning')
                    ->class('text-muted text-danger')
                    ->value('Note: Once you add new stock in the old, It cannot be undone!'),

            ]))
                ->applyButton('Add'),
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
                    Label::make('playgroup_total')
                        ->type('number')
                        ->class('text-center'),
                    Label::make('playgroup_assigned')
                        ->class('text-center'),
                    Label::make('playgroup_current')
                        ->class('text-center'),
                ]),
                Group::make([
                    Label::make('title')
                        ->title('Nursery'),
                    Label::make('nursery_total')
                        ->type('number')
                        ->class('text-center'),
                    Label::make('nursery_assigned')
                        ->class('text-center'),
                    Label::make('nursery_current')
                        ->class('text-center'),
                ]),
                Group::make([
                    Label::make('title')
                        ->title('Junior KG'),
                    Label::make('junior_kg_total')
                        ->type('number')
                        ->class('text-center'),
                    Label::make('junior_kg_assigned')
                        ->class('text-center'),
                    Label::make('junior_kg_current')
                        ->class('text-center'),
                ]),
                Group::make([
                    Label::make('title')
                        ->title('Senior KG'),
                    Label::make('senior_kg_total')
                        ->type('number')
                        ->class('text-center'),
                    Label::make('senior_kg_assigned')
                        ->class('text-center'),
                    Label::make('senior_kg_current')
                        ->class('text-center'),
                ]),
            ]),
            KitStockLogListLayout::class,
        ];
    }

    public function add(Request $request)
    {
        $request->validate([
            'program' => ['required', 'in:playgroup_total,nursery_total,junior_kg_total,senior_kg_total'],
            'quantity' => ['required', 'numeric'],
        ]);

        DB::transaction(function () use ($request) {
            $kitStock = KitStock::firstOrNew();
            $kitStock->{$request->program} += $request->quantity;
            $kitStock->save();

            $kitStock->logs()->create([
                'program' => static::PROGRAMS[$request->program],
                'quantity' => $request->quantity,
                'added_at' => now(),
            ]);
        });

        Toast::info('Updated stock successfully!');
        return redirect()->route('school.kit.stock');
    }
}
