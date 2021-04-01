<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Iterator;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        $crud = ['create', 'edit', 'delete', 'table'];
        $permissions = [
            'admission' => $crud,
            'enquiry' => $crud,
            'fees' => ['edit'],
            'receipt' => $crud,
        ];

        foreach ($permissions as $name => $permission) {
            $dashboard->registerPermissions($this->crud($name, $permission));
        }

        $admin = ItemPermission::group('admin')
            ->addPermission('admin.school', 'Manage School')
            ->addPermission('admin.user', 'Manage Users')
            ->addPermission('admin.role', 'Manage Roles');

        $dashboard->registerPermissions($admin);
    }

    public function crud($name, $permissions)
    {
        $p = ItemPermission::group($name);
        foreach ($permissions as $permission) {
            $p->addPermission($name . '.' . $permission, ucwords($permission . ' ' . $name));
        }
        return $p;
    }
}
