<?php

namespace App\Orchid\Screens\Admin;

use App\Models\Syllabus;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyllabusScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Syllabus';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Manage Syllabus';

    public $permission = 'admin.user';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'from_date' => working_year()[0],
            'to_date' => working_year()[1],
        ];
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
        return [
            Layout::view('components.syllabus'),
        ];
    }


    public function save(Request $request)
    {
        DB::transaction(function () use ($request) {
            // collect($request->input())
            //     ->each(
            //         fn ($subject) => array_key_exists('id', $subject) ?
            //             Syllabus::rebuildTree([$subject], true) :
            //             Syllabus::create($subject)
            //     );
            Syllabus::rebuildTree($request->input(), true);
        });
    }
}
