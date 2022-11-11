<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminAccountApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('admin')->group(function () {
    Route::prefix('accounts')->group(function () {
        Route::get('/', [AdminAccountApiController:: class, 'getApiAccount']);
        Route::delete('{id}/delete', [AdminAccountApiController::class, 'deleteAccountById']);
        Route::delete('deleteSelected', [AdminAccountApiController::class, 'deleteSelected'])->name('accounts.deleteSelected');
    });
});
