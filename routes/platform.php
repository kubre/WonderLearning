<?php

declare(strict_types=1);

use App\Models\School;
use App\Orchid\Screens\Account\FeesEditScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\ReceiptEditScreen;
use App\Orchid\Screens\ReceiptListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\School\AdmissionEditScreen;
use App\Orchid\Screens\School\AdmissionListScreen;
use App\Orchid\Screens\School\SchoolEditScreen;
use App\Orchid\Screens\School\SchoolListScreen;
use App\Orchid\Screens\Student\EnquiryEditScreen;
use App\Orchid\Screens\Student\EnquiryListScreen;
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

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{users}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Edit'), route('platform.systems.users.edit', $user));
    });

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
            ->parent('platform.systems.index')
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
            ->parent('platform.systems.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Example...
// Route::screen('example', ExampleScreen::class)
//     ->name('platform.example')
//     ->breadcrumbs(function (Trail $trail) {
//         return $trail
//             ->parent('platform.index')
//             ->push(__('Example screen'));
//     });

// Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
// Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
// Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
// Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
// Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
// Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

//Route::screen('idea', 'Idea::class','platform.screens.idea');

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

Route::screen('receipt/{receipt?}', ReceiptEditScreen::class)
    ->name('school.receipt.edit');
Route::screen('receipts', ReceiptListScreen::class)
    ->name('school.receipt.list');
