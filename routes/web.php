<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('auth')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth-logout');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot');
    Route::get('/unauthorized', [AuthController::class, 'unauthorized'])->name('auth.unauthorized');

    Route::post('/login', [AuthController::class, 'postLogin'])->name('auth-login');
    Route::post('/register', [AuthController::class, 'postRegister'])->name('auth-register');

});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('admin.dashboard');
    Route::prefix('accounts')->group(function () {
        Route::get('/', [AdminAccountController::class, 'index'])->name('accounts.index')
            ->middleware('can:accounts-list');
        Route::get('/create', [AdminAccountController::class, 'create'])->name('accounts.create')
            ->middleware('can:create-account');
        Route::get('{id}/edit', [AdminAccountController::class, 'edit'])->name('accounts.edit')
            ->middleware('can:edit-account');
        Route::post('/store', [AdminAccountController::class, 'store'])->name('accounts.store')
            ->middleware('can:create-account');
        Route::put('/{id}', [AdminAccountController::class, 'update'])->name('accounts.update')
            ->middleware('can:edit-account');
        Route::get('{id}/change-password', [AdminAccountController:: class, 'editPassword'])
            ->name('accounts.editpassword')->middleware('can:edit-account');
        Route::put('{id}/change-password', [AdminAccountController::class, 'updatePassword'])
            ->name('accounts.updatepassword')->middleware('can:edit-account');
    });

    Route::prefix('permissions')->group(function () {
        Route::get('/', [AdminPermissionController::class, 'index'])->name('permissions.index')
            ->middleware('can:permissions-list');
        Route::get('/create', [AdminPermissionController::class, 'create'])->name('permissions.create')
            ->middleware('can:create-permission');
        Route::get('{id}/edit', [AdminPermissionController::class, 'edit'])->name('permissions.edit')
            ->middleware('can:edit-permission');
        Route::post('/store', [AdminPermissionController::class, 'store'])->name('permissions.store')
            ->middleware('can:create-permission');
        Route::put('/{id}', [AdminPermissionController::class, 'update'])->name('permissions.update')
            ->middleware('can:edit-permission');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [AdminRoleController::class, 'index'])->name('roles.index')
            ->middleware('can:roles-list');
        Route::get('/create', [AdminRoleController::class, 'create'])->name('roles.create')
            ->middleware('can:create-role');
        Route::get('{id}/edit', [AdminRoleController::class, 'edit'])->name('roles.edit')
            ->middleware('can:edit-role');
        Route::post('/store', [AdminRoleController::class, 'store'])->name('roles.store')
            ->middleware('can:create-role');
        Route::put('/{id}', [AdminRoleController::class, 'update'])->name('roles.update')
            ->middleware('can:edit-role');
    });
});
