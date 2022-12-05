<?php

namespace App\Providers;

use App\Repositories\Eloquent\Admin\EloquentAccountRepository;
use App\Repositories\Eloquent\Admin\EloquentAttributeRepository;
use App\Repositories\Eloquent\Admin\EloquentAttributeValueRepository;
use App\Repositories\Eloquent\Admin\EloquentCategoryRepository;
use App\Repositories\Eloquent\Admin\EloquentPermissionRepository;
use App\Repositories\Eloquent\Admin\EloquentProductAttributeValueRepository;
use App\Repositories\Eloquent\Admin\EloquentProductRepository;
use App\Repositories\Eloquent\Admin\EloquentRoleRepository;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Repositories\Eloquent\User\EloquentHomeRepository;
use App\Repositories\Interfaces\Admin\IAccountRepository;
use App\Repositories\Interfaces\Admin\IAttributeRepository;
use App\Repositories\Interfaces\Admin\IAttributeValueRepository;
use App\Repositories\Interfaces\Admin\ICategoryRepository;
use App\Repositories\Interfaces\Admin\IPermissionRepository;
use App\Repositories\Interfaces\Admin\IProductAttributeValueRepository;
use App\Repositories\Interfaces\Admin\IProductRepository;
use App\Repositories\Interfaces\Admin\IRoleRepository;
use App\Repositories\Interfaces\Auth\IAuthRepository;
use App\Repositories\Interfaces\User\IHomeRepository;
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
        //Admin
        $this->app->singleton(IAccountRepository::class, EloquentAccountRepository::class);
        $this->app->singleton(ICategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->singleton(IPermissionRepository::class, EloquentPermissionRepository::class);
        $this->app->singleton(IProductRepository::class, EloquentProductRepository::class);
        $this->app->singleton(IRoleRepository::class, EloquentRoleRepository::class);
        $this->app->singleton(IAuthRepository::class, AuthRepository::class);
        $this->app->singleton(IAttributeRepository::class, EloquentAttributeRepository::class);
        $this->app->singleton(IAttributeValueRepository::class, EloquentAttributeValueRepository::class);
        $this->app->singleton(IProductAttributeValueRepository::class, EloquentProductAttributeValueRepository::class);

        //User
        $this->app->singleton(IHomeRepository::class, EloquentHomeRepository::class);
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
