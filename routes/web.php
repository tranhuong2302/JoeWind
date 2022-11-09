<?php

use App\Http\Controllers\Admin\AdminAccountController;
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
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->middleware('auth')->name('admin.dashboard');
    Route::prefix('accounts')->group(function () {
        Route::get('/', [AdminAccountController::class, 'index'])->name('accounts.index');
        Route::get('/create', [AdminAccountController::class, 'create'])->name('account.create');
        Route::post('/store', [AdminAccountController::class, 'store'])->name('account.store');
    });
});
