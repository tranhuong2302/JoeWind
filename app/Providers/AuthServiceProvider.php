<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Account
        Gate::define('accounts-list', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.list_accounts'));
        });
        Gate::define('create-account', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.create_account'));
        });
        Gate::define('edit-account', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.edit_account'));
        });
        Gate::define('delete-account', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.delete_account'));
        });

        //Role
        Gate::define('roles-list', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.list_roles'));
        });
        Gate::define('create-role', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.create_role'));
        });
        Gate::define('edit-role', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.edit_role'));
        });
        Gate::define('delete-role', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.delete_role'));
        });

        //Role
        Gate::define('permissions-list', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.list_permissions'));
        });
        Gate::define('create-permission', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.create_permission'));
        });
        Gate::define('edit-permission', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.edit_permission'));
        });
        Gate::define('delete-permission', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.delete_permission'));
        });
    }
}
