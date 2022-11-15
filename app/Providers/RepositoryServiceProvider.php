<?php

namespace App\Providers;

use App\Repositories\Eloquent\Admin\EloquentAccountRepository;
use App\Repositories\Eloquent\Admin\EloquentCategoryRepository;
use App\Repositories\Eloquent\Admin\EloquentPermissionRepository;
use App\Repositories\Eloquent\Admin\EloquentProductRepository;
use App\Repositories\Eloquent\Admin\EloquentRoleRepository;
use App\Repositories\Interfaces\Admin\IAccountRepository;
use App\Repositories\Interfaces\Admin\ICategoryRepository;
use App\Repositories\Interfaces\Admin\IPermissionRepository;
use App\Repositories\Interfaces\Admin\IProductRepository;
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
        $this->app->singleton(ICategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->singleton(IPermissionRepository::class, EloquentPermissionRepository::class);
        $this->app->singleton(IProductRepository::class, EloquentProductRepository::class);
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
