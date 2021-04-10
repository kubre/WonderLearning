<?php

namespace App\Orchid;

use App\Models\User;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;
use Session;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // This code is to make sure if working year in session ever gets out of sync just sync it back
        if (!is_academic_year_in_sync(school()->academic_year)) {
            Session::forget('_working_year');
        }

        // ...
    }

    /**
     * @return ItemMenu[]
     */
    public function registerMainMenu(): array
    {
        /** @var User */
        $user = auth()->user();
        return [
            ItemMenu::label('Dashboard')
                ->icon('speedometer')
                ->url('/admin')
                ->title('Menu'),
            ItemMenu::label('Schools')
                ->icon('building')
                ->permission('admin.school')
                ->route('admin.school.list'),

            ItemMenu::label('Admissions')
                ->slug('admissions')
                ->icon('graduation')
                ->badge(fn () => '▶', Color::DEFAULT())
                ->withChildren()
                ->hideEmpty(),
            ItemMenu::label('Enquiry')
                ->place('admissions')
                ->icon('info')
                ->permission('enquiry.table')
                ->route('school.enquiry.list'),
            ItemMenu::label('Admission')
                ->place('admissions')
                ->icon('user')
                ->permission('admission.table')
                ->route('school.admission.list'),

            ItemMenu::label('Accounts')
                ->icon('rupee')
                ->slug('accounts')
                ->badge(fn () => '▶', Color::DEFAULT())
                ->withChildren()
                ->hideEmpty(),
            ItemMenu::label('Fee Rate Card')
                ->place('accounts')
                ->icon('note')
                ->permission('fees.edit')
                ->route('account.fees.edit'),
            ItemMenu::label('Fees Receipt Generation')
                ->place('accounts')
                ->icon('money')
                ->permission('receipt.create')
                ->route('school.receipt.list'),

            ItemMenu::label('Sign Out')
                ->icon('logout')
                ->route('auth.signout', [optional(session('school'))->login_url ?? 'admin']),
        ];
    }

    /**
     * @return ItemMenu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            ItemMenu::label('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemMenu[]
     */
    public function registerSystemMenu(): array
    {
        return [
            ItemMenu::label(__('Access rights'))
                ->icon('lock')
                ->slug('Auth')
                ->active('platform.systems.*')
                ->permission('platform.systems.index')
                ->sort(1000),

            ItemMenu::label(__('Users'))
                ->place('Auth')
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->sort(1000)
                ->title(__('All registered users')),

            ItemMenu::label(__('Roles'))
                ->place('Auth')
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->sort(1000)
                ->title(__('A Role defines a set of tasks a user assigned the role is allowed to perform.')),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('Systems'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }

    /**
     * @return string[]
     */
    public function registerSearchModels(): array
    {
        return [
            // ...Models
            // \App\Models\User::class,
        ];
    }
}
