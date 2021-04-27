<?php

namespace App\Orchid;

use App\Models\User;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;
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
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        /** @var User */
        $user = auth()->user();
        return [

            Menu::make('Dashboard')
                ->icon('speedometer')
                ->title('Menu')
                ->url('/admin'),
            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users'),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),

            Menu::make('Schools')
                ->icon('building')
                ->permission('admin.school')
                ->route('admin.school.list'),
            Menu::make(__('Syllabus'))
                ->icon('notebook')
                ->permission('admin.school')
                ->route('admin.syllabus'),
            Menu::make('Export Data')
                ->icon('table')
                ->permission('admin.export')
                ->route('admin.export'),

            Menu::make('Admissions')
                ->icon('graduation')
                ->permission('admission.table')
                ->badge(fn () => '▶', Color::DEFAULT())
                ->list([
                    Menu::make('Enquiry')
                        ->icon('info')
                        ->permission('admission.table')
                        ->route('school.enquiry.list'),
                    Menu::make('Admission')
                        ->icon('user')
                        ->permissions('enquiry.table')
                        ->route('school.admission.list'),
                ]),

            Menu::make('Accounts')
                ->icon('rupee')
                ->permission('receipt.table')
                ->badge(fn () => '▶', Color::DEFAULT())
                ->list([
                    Menu::make('Fee Rate Card')
                        ->place('accounts')
                        ->icon('note')
                        ->permission('fees.edit')
                        ->route('account.fees.edit'),
                    Menu::make('Fees Receipt Generation')
                        ->place('accounts')
                        ->icon('money')
                        ->permission('receipt.create')
                        ->route('school.receipt.list'),
                    Menu::make('Payment Due Report')
                        ->place('accounts')
                        ->icon('docs')
                        ->permission('receipt.table')
                        ->route('account.payment-due.report'),
                    Menu::make('Canceled Receipt Logs')
                        ->place('accounts')
                        ->icon('trash')
                        ->permission('receipt.table')
                        ->route('account.canceled-log.report'),
                    Menu::make('Online Payments Report')
                        ->place('accounts')
                        ->icon('rupee')
                        ->permission('receipt.table')
                        ->route('account.online-payments.report'),
                    Menu::make('Daily Collection Report')
                        ->place('accounts')
                        ->icon('calendar')
                        ->permission('receipt.table')
                        ->route('account.daily-collection.report'),
                ]),

            Menu::make('Reports')
                ->icon('docs')
                ->permission('admission.table')
                ->badge(fn () => '▶', Color::DEFAULT())
                ->list([
                    Menu::make('Admissions Report')
                        ->place('reports')
                        ->icon('user')
                        ->permission('admission.table')
                        ->route('reports.admissions.report'),
                    Menu::make('Enquiry Report')
                        ->place('reports')
                        ->icon('info')
                        ->permission('admission.table')
                        ->route('reports.enquiries.report'),
                ]),

            Menu::make('Users')
                ->icon('people')
                ->permission('school.users')
                ->route('school.users'),

            Menu::make('Kit Stock')
                ->icon('module')
                ->permission('school.users')
                ->route('school.kit.stock'),


            Menu::make('Sign Out')
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
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
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
