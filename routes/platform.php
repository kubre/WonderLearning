<?php

declare(strict_types=1);

use App\Models\PerformanceReport;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Account\CanceledLogScreen;
use App\Orchid\Screens\Account\DailyCollectionReportScreen;
use App\Orchid\Screens\Account\FeesEditScreen;
use App\Orchid\Screens\Account\OnlinePaymentsScreen;
use App\Orchid\Screens\Account\PaymentDueReportScreen;
use App\Orchid\Screens\Admin\ExportScreen;
use App\Orchid\Screens\Admin\ProgramSubjectsScreen;
use App\Orchid\Screens\Admin\SyllabusScreen;
use App\Orchid\Screens\DeclarationFormScreen;
use App\Orchid\Screens\Reports\AdmissionReportScreen;
use App\Orchid\Screens\Reports\EnquiryReportScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\School\ReceiptEditScreen;
use App\Orchid\Screens\School\ReceiptListScreen;
use App\Orchid\Screens\School\AdmissionEditScreen;
use App\Orchid\Screens\School\AdmissionListScreen;
use App\Orchid\Screens\School\AttendanceReportScreen;
use App\Orchid\Screens\School\DivisionScreen;
use App\Orchid\Screens\School\GalleryEditScreen;
use App\Orchid\Screens\School\GalleryListScreen;
use App\Orchid\Screens\School\GraduationScreen;
use App\Orchid\Screens\School\HolidayEditScreen;
use App\Orchid\Screens\School\HolidayListScreen;
use App\Orchid\Screens\School\KitStockScreen;
use App\Orchid\Screens\School\PerformanceReportApprovalScreen;
use App\Orchid\Screens\School\ReceiptPrintScreen;
use App\Orchid\Screens\School\SchoolEditScreen;
use App\Orchid\Screens\School\SchoolListScreen;
use App\Orchid\Screens\School\SelectYearScreen;
use App\Orchid\Screens\School\UserEditScreen as SchoolUserEditScreen;
use App\Orchid\Screens\School\UserListScreen as SchoolUserListScreen;
use App\Orchid\Screens\Student\EnquiryEditScreen;
use App\Orchid\Screens\Student\EnquiryListScreen;
use App\Orchid\Screens\Student\InstallmentEditScreen;
use App\Orchid\Screens\Student\InvoicePrintScreen;
use App\Orchid\Screens\Teacher\AttendanceEditScreen;
use App\Orchid\Screens\Teacher\AttendanceListScreen;
use App\Orchid\Screens\Teacher\BookListScreen;
use App\Orchid\Screens\Teacher\ChatListScreen;
use App\Orchid\Screens\Teacher\ChatUIScreen;
use App\Orchid\Screens\Teacher\HomeworkEditScreen;
use App\Orchid\Screens\Teacher\HomeworkListScreen;
use App\Orchid\Screens\Teacher\NoticeEditScreen;
use App\Orchid\Screens\Teacher\NoticeListScreen;
use App\Orchid\Screens\Teacher\PerformanceReportEditScreen;
use App\Orchid\Screens\Teacher\PerformanceReportFillingScreen;
use App\Orchid\Screens\Teacher\StudentListScreen;
use App\Orchid\Screens\Teacher\SubjectListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

Route::screen('/main', PlatformScreen::class)
    ->name('platform.main')
    ->middleware('working.year');

Route::screen('/select-year', SelectYearScreen::class)
    ->name('school.select.year');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit');

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{roles}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Admin
Route::screen('exports', ExportScreen::class)
    ->name('admin.export')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Export Screen'), route('admin.export'))
    );

Route::screen('syllabus', SyllabusScreen::class)
    ->name('admin.syllabus')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Syllabus Management'), route('admin.syllabus'))
    );

Route::screen('program-subjects', ProgramSubjectsScreen::class)
    ->name('admin.program-subjects')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Add Subject to Programme'), route('admin.program-subjects'))
    );

// School > Users
Route::screen('school/users/{users}/edit', SchoolUserEditScreen::class)
    ->name('school.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('school.users')
            ->push(__('Edit'), route('school.users.edit', $user));
    });

// School > Users > Create
Route::screen('school/users/create', SchoolUserEditScreen::class)
    ->name('school.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('school.users')
            ->push(__('Create'), route('school.users.create'));
    });

// School > Users
Route::screen('school/users', SchoolUserListScreen::class)
    ->name('school.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('school.users'));
    });

Route::screen('kit', KitStockScreen::class)
    ->name('school.kit.stock')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Kit Stock'), route('school.kit.stock'));
    });

Route::screen('school/{school?}', SchoolEditScreen::class)
    ->name('admin.school.edit');
Route::screen('schools', SchoolListScreen::class)
    ->name('admin.school.list');

Route::screen('enquiry/{enquiry?}', EnquiryEditScreen::class)
    ->name('school.enquiry.edit');
Route::screen('enquiries', EnquiryListScreen::class)
    ->name('school.enquiry.list');

Route::screen('fees/{fees?}', FeesEditScreen::class)
    ->name('account.fees.edit');

Route::screen('admission/{admission?}', AdmissionEditScreen::class)
    ->name('school.admission.edit');

Route::screen('admissions', AdmissionListScreen::class)
    ->name('school.admission.list');

Route::screen('graduation/{admission?}', GraduationScreen::class)
    ->name('school.graduation.edit');

Route::screen('receipt/{receipt?}', ReceiptEditScreen::class)
    ->name('school.receipt.edit');

Route::screen('receipts', ReceiptListScreen::class)
    ->name('school.receipt.list');

Route::screen('receipts/{receipt}/{parent}', ReceiptPrintScreen::class)
    ->name('school.receipt.print');

Route::screen('installment/{admission}', InstallmentEditScreen::class)
    ->name('school.installment.edit');

Route::screen('invoice/{admission}/{parent}', InvoicePrintScreen::class)
    ->name('school.invoice.print');

Route::screen('account/reports/payment-due-report', PaymentDueReportScreen::class)
    ->name('account.payment-due.report');

Route::screen('account/reports/canceled-log', CanceledLogScreen::class)
    ->name('account.canceled-log.report');

Route::screen('account/reports/online-payments', OnlinePaymentsScreen::class)
    ->name('account.online-payments.report');

Route::screen('account/reports/daily-collection', DailyCollectionReportScreen::class)
    ->name('account.daily-collection.report');

Route::screen('reports/admissions', AdmissionReportScreen::class)
    ->name('reports.admissions.report');

Route::screen('reports/enquiries', EnquiryReportScreen::class)
    ->name('reports.enquiries.report');

Route::screen('divisions', DivisionScreen::class)
    ->name('school.divisions')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Divisions Management'), route('school.divisions'))
    );

Route::screen('students', StudentListScreen::class)
    ->name('teacher.students.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Student List'), route('teacher.students.list'))
    );

Route::screen('performance/filling', PerformanceReportFillingScreen::class)
    ->name('teacher.performance.filling')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Performance Report Filling'), route('teacher.performance.filling'))
    );

Route::screen('chats/{student}', ChatUIScreen::class)
    ->name('teacher.chats.screen')
    ->breadcrumbs(
        fn (Trail $trail, $student) => $trail
            ->parent('teacher.chats.list')
            ->push(
                __("Chat with {$student->name}'s Parent's"),
                route('teacher.chats.screen', compact('student'))
            )
    );

Route::screen('chats', ChatListScreen::class)
    ->name('teacher.chats.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Chats'), route('teacher.chats.list'))
    );

Route::screen('subjects', SubjectListScreen::class)
    ->name('teacher.subjects')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Subjects'), route('teacher.subjects'))
    );

Route::screen('homework/{homework?}', HomeworkEditScreen::class)
    ->name('teacher.homework.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('teacher.homework')
            ->push(__('Add Homework'), route('teacher.homework.edit'))
    );

Route::screen('homework-list', HomeworkListScreen::class)
    ->name('teacher.homework')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Homework'), route('teacher.homework'))
    );

Route::screen('holiday/{holiday?}', HolidayEditScreen::class)
    ->name('school.holiday.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('school.holiday')
            ->push(__('Add Holiday'), route('school.holiday.edit'))
    );

Route::screen('holidays', HolidayListScreen::class)
    ->name('school.holiday')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Manage Holidays'), route('school.holiday'))
    );

Route::screen('gallery/{gallery?}', GalleryEditScreen::class)
    ->name('school.gallery.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('school.gallery')
            ->push(__('Add Collection'), route('school.gallery.edit'))
    );

Route::screen('galleries', GalleryListScreen::class)
    ->name('school.gallery')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Manage Gallery'), route('school.gallery'))
    );

Route::screen('notice/{notice?}', NoticeEditScreen::class)
    ->name('teacher.notice.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('teacher.notice')
            ->push(__('Issue Notice'), route('teacher.notice.edit'))
    );

Route::screen('notices', NoticeListScreen::class)
    ->name('teacher.notice')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Notice Board'), route('teacher.notice'))
    );

Route::screen('subject/{syllabus}', BookListScreen::class)
    ->name('teacher.subjects.book')
    ->breadcrumbs(
        fn (Trail $trail, $syllabus) => $trail
            ->parent('teacher.subjects')
            ->push(__('Book'), route('teacher.subjects.book', $syllabus))
    );

Route::screen('attendances/create', AttendanceEditScreen::class)
    ->name('teacher.attendance.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('teacher.attendance.list')
            ->push(__('Record Attendance'), route('teacher.attendance.create'))
    );

Route::screen('attendances', AttendanceListScreen::class)
    ->name('teacher.attendance.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Attendance'), route('teacher.attendance.list'))
    );

Route::screen('report/attendance', AttendanceReportScreen::class)
    ->name('reports.attendance.monthly')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Monthly Attendance Report'), route('reports.attendance.monthly'))
    );

Route::screen('declaration/{admission}', DeclarationFormScreen::class)
    ->name('reports.declaration.form');

Route::screen('report/performance/approval', PerformanceReportApprovalScreen::class)
    ->name('reports.performance.approval')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Monthly Performance Report Approval'),
                route('reports.performance.approval')
            )
    );

Route::screen('report/performance/{admissionId}/{month}', PerformanceReportEditScreen::class)
    ->name('reports.performance.fill')
    ->breadcrumbs(
        fn (Trail $trail, int $admissionId, string $month) => $trail
            ->parent('teacher.students.list')
            ->push(
                __('Monthly Performance Report'),
                route('reports.performance.fill', compact('admissionId', 'month'))
            )
    );
