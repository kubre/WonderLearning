<?php

namespace App\Orchid;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    public User $user;

    public array $subjects = [];

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
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        if (!Session::exists('school')) {
            session(['school' => auth()->user()->school]);
        }

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
            Menu::make(__('Add Subjects to Programme'))
                ->icon('share')
                ->permission('admin.school')
                ->canSee(false)
                ->route('admin.program-subjects'),
            Menu::make('Export Data')
                ->icon('table')
                ->permission('admin.export')
                ->route('admin.export'),


            // School Menu
            Menu::make('Users')
                ->icon('people')
                ->permission('school.users')
                ->route('school.users'),

            Menu::make('Divisions')
                ->icon('layers')
                ->permission('school.users')
                ->route('school.divisions'),

            Menu::make('Kit Stock')
                ->icon('module')
                ->permission('school.users')
                ->route('school.kit.stock'),

            Menu::make('Admissions')
                ->icon('graduation')
                ->permission('menu.admission')
                ->badge(fn () => '▶', Color::DEFAULT())
                ->list([
                    Menu::make('Enquiry')
                        ->icon('info')
                        ->permission('enquiry.table')
                        ->route('school.enquiry.list'),
                    Menu::make('Admission')
                        ->icon('user')
                        ->permission('admission.table')
                        ->route('school.admission.list'),
                ]),

            Menu::make('Accounts')
                ->icon('rupee')
                ->permission('menu.account')
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
                ->permission('menu.report')
                ->badge(fn () => '▶', Color::DEFAULT())
                ->list([
                    Menu::make('Admissions Report')
                        ->icon('user')
                        ->permission('admission.table')
                        ->route('reports.admissions.report'),
                    Menu::make('Enquiry Report')
                        ->icon('info')
                        ->permission('admission.table')
                        ->route('reports.enquiries.report'),
                    Menu::make('Monthly Attendance')
                        ->icon('table')
                        ->permission('menu.report')
                        ->route('reports.attendance.monthly'),
                    Menu::make('Performance Report Approval')
                        ->icon('check')
                        ->permission('school.users')
                        ->route('reports.performance.approval'),
                ]),

            Menu::make('Holidays')
                ->icon('calendar')
                ->permission('school.users')
                ->route('school.holiday'),

            Menu::make('Gallery')
                ->icon('picture')
                ->permission('school.users')
                ->route('school.gallery'),

            // Options for Teacher
            Menu::make('Students')
                ->icon('people')
                ->permission('teacher.student')
                ->route('teacher.students.list'),

            Menu::make('Subjects')
                ->icon('notebook')
                ->permission('teacher.subjects')
                ->route('teacher.subjects'),

            Menu::make('Homework')
                ->icon('pencil')
                ->permission('teacher.subjects')
                ->route('teacher.homework'),

            Menu::make('Notice Board')
                ->icon('bell')
                ->permission('menu.report')
                ->route('teacher.notice'),

            Menu::make('Sign Out')
                ->icon('logout')
                ->route('auth.signout', [optional(school())->login_url ?? 'admin']),
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
