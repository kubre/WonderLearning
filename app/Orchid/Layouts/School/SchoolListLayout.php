<?php

namespace App\Orchid\Layouts\School;

use App\Models\School;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SchoolListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'schools';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('logo', 'School Logo')
                ->render(fn (School $s) =>
                    "<img src='{$s->logo}' height='80'>"),
            TD::make('name', 'School Name')->sort(),
            TD::make('email', 'Email'),
            TD::make('login_url', 'Login Url')
                ->render(fn (School $s) => 
                    Link::make($s->login_url)->icon('globe')
                    ->target('_blank')->href(env('APP_URL').'/login/'.$s->login_url)),
            TD::make('actions', 'Actions')
                ->render(fn (School $s) =>
                    Link::make('Edit')->icon('note')->route('admin.school.edit', $s))
        ];
    }
}
