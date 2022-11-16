<?php

use App\Http\Controllers\Api\Admin\AdminAccountApiController;
use App\Http\Controllers\Api\Admin\AdminProductApiController;
use App\Http\Controllers\Api\Admin\AdminRoleApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//        Route::delete('{id}/delete', [AdminAccountApiController::class, 'deleteAccountById']);
//        Route::delete('deleteSelected', [AdminAccountApiController::class, 'deleteSelected']);
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductApiController::class, 'getApiProducts']);
//        Route::delete('{id}/delete', [AdminProductApiController::class, 'deleteProductById']);
//        Route::delete('deleteSelected', [AdminProductApiController::class, 'deleteSelected']);
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [AdminRoleApiController::class, 'getApiRoles']);
//        Route::delete('{id}/delete', [AdminRoleApiController::class, 'deleteRoleById']);
//        Route::delete('deleteSelected', [AdminRoleApiController::class, 'deleteSelected']);
    });

    //    Route::prefix('categories')->group(function () {
//        Route::get('/', [AdminCategoryApiController::class, 'getApiCategories']);
//        Route::delete('{id}/delete', [AdminCategoryApiController::class, 'deleteCategoryById']);
//        Route::delete('deleteSelected', [AdminCategoryApiController::class, 'deleteSelected']);
//    });

//    Route::prefix('permissions')->group(function () {
//        Route::get('/', [AdminPermissionApiController::class, 'getApiPermissions']);
//        Route::delete('{id}/delete', [AdminPermissionApiController::class, 'deletePermissionById']);
//        Route::delete('deleteSelected', [AdminPermissionApiController::class, 'deleteSelected']);
//    });


});
