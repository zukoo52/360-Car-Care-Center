<?php

use App\Http\Controllers\API\ApiBranchController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VehicleOwnerController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::get('/me', [UserController::class, 'profile'])->name('user.profile');
    });

    Route::prefix('permission')->group(function () {
        Route::get('', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/{id}', [PermissionController::class, 'show'])->name('permission.show');
    });

    Route::prefix('branch')->group(function () {
        Route::get('', [BranchController::class, 'create'])->name('branch.create');
        Route::get('view', [BranchController::class, 'index'])->name('branch.index');
        Route::get('update/{id}', [BranchController::class, 'update'])->name('branch.update');
    });

    Route::prefix('notifications')->group(function () {
        Route::get('user', [NotificationController::class, 'showUserNotification'])->name('user.notifications');
        Route::get('system', [NotificationController::class, 'showSystemNotifications'])->name('system.notifications');
    });

    //create product routs urls
    Route::prefix('product')->group(function(){
        Route::get('', [ProductController::class, 'create'])->name('product.create');
        Route::get('view', [ProductController::class, 'index'])->name('product.index');
        Route::get('update/{id}', [ProductController::class, 'update'])->name('product.update');
    });
});
