<?php

namespace App\Providers;

use App\Repositories\Eloquent\Admin\EloquentAccountRepository;
use App\Repositories\Eloquent\Admin\EloquentPermissionRepository;
use App\Repositories\Eloquent\Admin\EloquentRoleRepository;
use App\Repositories\Interfaces\Admin\IAccountRepository;
use App\Repositories\Interfaces\Admin\IPermissionRepository;
use App\Repositories\Interfaces\Admin\IRoleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IAccountRepository::class, EloquentAccountRepository::class);
        $this->app->singleton(IPermissionRepository::class, EloquentPermissionRepository::class);
        $this->app->singleton(IRoleRepository::class, EloquentRoleRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
