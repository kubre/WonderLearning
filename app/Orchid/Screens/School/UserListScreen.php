<?php

namespace App\Orchid\Screens\School;

use App\Models\User;
use App\Orchid\Layouts\School\UserListLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserFiltersLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Users';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Users List Screen';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'users' => User::filters()
                ->filtersApplySelection(UserFiltersLayout::class)
                ->ofSchool(school()->id)
                ->simplePaginate(),
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
            Link::make(__('Add'))
                ->icon('plus')
                ->type(Color::PRIMARY())
                ->route('school.users.create'),
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
            UserFiltersLayout::class,
            UserListLayout::class,

            Layout::modal('oneAsyncModal', UserEditLayout::class)
                ->async('asyncGetUser'),
        ];
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function asyncGetUser(User $user): array
    {
        return [
            'user' => $user,
        ];
    }

    /**
     * @param User    $user
     * @param Request $request
     */
    public function saveUser(User $user, Request $request)
    {
        if ($user->school_id !== school()->id) {
            return;
        }

        $request->validate([
            'user.email' => 'required|unique:users,email,' . $user->id,
        ]);

        $user->fill($request->input('user'))
            ->save();

        Toast::info(__('User was saved.'));
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request)
    {
        User::findOrFail($request->get('id'))
            ->delete();

        Toast::info(__('User was removed.'));
    }
}
