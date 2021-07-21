<?php

namespace App\Orchid\Screens\Teacher;

use App\Models\Notice;
use App\Orchid\Layouts\Teacher\NoticeListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class NoticeListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Notice Board';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Issued notice will be visible to parents in respective division.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'notices' => Notice::with('division', 'user')
                ->filters()
                ->orderBy('id', 'DESC')
                ->simplePaginate(20),
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
            Link::make('Issue a Notice')
                ->icon('plus')
                ->type(Color::PRIMARY())
                ->route('teacher.notice.edit'),
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
            NoticeListLayout::class,
        ];
    }

    public function remove(Notice $notice)
    {
        $notice->delete();
        Toast::info('Removed the notice successfully!');
        return \redirect()->route('teacher.notice');
    }
}
