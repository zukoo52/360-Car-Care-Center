<?php

use App\Http\Controllers\API\ApiBranchController;
use App\Http\Controllers\API\ApiNotificationController;
use App\Http\Controllers\API\ApiProductController;
use App\Http\Controllers\API\ApiRoleController;
use App\Http\Controllers\API\ApiSupplyController;
use App\Http\Controllers\API\ApiUserController;
use App\Http\Controllers\BranchController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('notifications')->group(function () {
        Route::prefix('system')->group(function () {
            Route::get('', [ApiNotificationController::class, 'getSystemNotifications'])->name('notifications.getSystem');
            Route::post('/{id}/read', [ApiNotificationController::class, 'markAsReadSystemNotification'])->name('notifications.markReadSystem');
            Route::delete('/{id}', [ApiNotificationController::class, 'deleteSystemNotification'])->name('notifications.deleteSystem');
        });
        Route::prefix('user')->group(function () {
            Route::get('', [ApiNotificationController::class, 'getUserNotifications'])->name('notifications.getUser');
            Route::post('/{id}/read', [ApiNotificationController::class, 'markAsReadUserNotification'])->name('notifications.markReadUser');
            Route::delete('/{id}', [ApiNotificationController::class, 'deleteUserNotification'])->name('notifications.deleteUser');
        });
    });
    Route::prefix('role')->group(function () {
        Route::get('', [ApiRoleController::class, 'getAssignableRoles'])->name('role.assignableRoles');
        Route::post('', [ApiRoleController::class, 'createNewRole'])->name('role.create');
        Route::get('/{id}/permissions', [ApiRoleController::class, 'getRolePermissions'])->name('role.permissions');
        Route::patch('/{id}/permissions', [ApiRoleController::class, 'updateRolePermissions'])->name('role.permissions.update');
    });
    Route::prefix('branch')->group(function () {
        Route::get('', [ApiBranchController::class,'getBranches'])->name('branch.Branches');
        Route::post('/create', [ApiBranchController::class,'createNewBranch'])->name('branch.create');
        Route::get('/{id}/update', [ApiBranchController::class,'getUpdateBranch'])->name('branch');
        Route::patch('/{id}/update', [ApiBranchController::class,'updateBranch'])->name('branch.update');
        Route::patch('/{id}/delete', [ApiBranchController::class,'deleteBranch'])->name('branch.delete');
    });

    //create product api routes

    Route::prefix('product')->group(function () {
        Route::get('', [ApiProductController::class,'getProducts'])->name('product.Branches');
        Route::post('/create', [ApiProductController::class,'createNewProduct'])->name('product.create');
        Route::patch('/{id}/update', [ApiProductController::class,'updateProduct'])->name('product.update');
        Route::patch('/{id}/delete', [ApiProductController::class,'deleteProduct'])->name('product.delete');
    });

});
