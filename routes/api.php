<?php

use App\Http\Controllers\Api\Admin\AdminAccountApiController;
use App\Http\Controllers\Api\Admin\AdminAttributeApiController;
use App\Http\Controllers\Api\Admin\AdminCategoryApiController;
use App\Http\Controllers\Api\Admin\AdminProductApiController;
use App\Http\Controllers\Api\Admin\AdminProductAttributeValueApiController;
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
    });
    Route::prefix('categories')->group(function () {
        Route::get('/', [AdminCategoryApiController:: class, 'getApiCategories']);
    });
    Route::prefix('attributes')->group(function () {
        Route::get('/', [AdminAttributeApiController:: class, 'getApiAttribute']);
        Route::get('/{id}/values', [AdminAttributeApiController:: class, 'findApiAttributeValueByAttributeId'])
            ->name('attributes.values');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductApiController::class, 'getApiProducts']);
    });
    Route::prefix('product/{id}/values')->group(function () {
        Route::get('', [AdminProductAttributeValueApiController::class, 'getApiProductAttributeValue'])->name('apiProductValues.index');
        Route::get('/{idValue}', [AdminProductAttributeValueApiController::class, 'findProductAttributeValueById']);
        Route::put('/{idValue}', [AdminProductAttributeValueApiController::class, 'update']);
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [AdminRoleApiController::class, 'getApiRoles']);
    });


});
