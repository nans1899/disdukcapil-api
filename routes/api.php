<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\MenuManagementController;
use App\Http\Controllers\Api\MenusController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\SubmenusController;
use App\Http\Controllers\Api\TestingController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Login
Route::post('login', [AuthController::class, 'login'])->middleware('guest')->name('api.login');

Route::middleware(['auth:api'])->group(function () {

    // Dahboard Index
    Route::get('dashboard-index',[DashboardController::class, 'index'])->name('dashboard.index');

    // Sidemenus
    Route::get('roles', [MenusController::class, 'getRole'])->name('api.roles'); // clear
    Route::get('all', [MenusController::class, 'allMenus'])->name('api.all'); //clear
    Route::get('menus', [MenusController::class, 'getMenus'])->name('api.menus'); //clear
    Route::get('submenus/{id}', [MenusController::class, 'getSubmenus'])->name('api.submenus'); //clear

    // Get Ticket
    Route::get('ticket', [MenusController::class, 'getTicket'])->name('api.ticket');

    // User
    Route::get('user-management', [UserController::class, 'index'])->middleware('superadmin')->name('user.index');
    Route::get('user-management/{id}/detail', [UserController::class, 'detail'])->middleware('superadmin')->name('user.detail');
    Route::post('user-management', [UserController::class, 'store'])->middleware('superadmin')->name('user.store');
    Route::put('user-management/{id}/update', [UserController::class, 'update'])->middleware('superadmin')->name('user.update');
    Route::delete('user-management/{id}', [UserController::class, 'destroy'])->middleware('superadmin')->name('user.destroy');

    // Menu Management
    Route::get('menu-management', [MenuManagementController::class, 'index'])->middleware('superadmin')->name('menu.index');
    Route::get('menu-management/{id}/detail', [MenuManagementController::class, 'detail'])->middleware('superadmin')->name('menu.detail');
    Route::post('menu-management', [MenuManagementController::class, 'store'])->middleware('superadmin')->name('menu.store');
    Route::put('menu-management/{id}/update', [MenuManagementController::class, 'update'])->middleware('superadmin')->name('menu.update');
    Route::delete('menu-management/{id}', [MenuManagementController::class, 'destroy'])->middleware('superadmin')->name('menu.delete');

    // Role Management
    Route::get('role-management', [RoleController::class, 'index'])->middleware('superadmin')->name('role.index');
    Route::get('role-management/{id}/detail', [RoleController::class, 'detail'])->middleware('superadmin')->name('role.detail');
    Route::post('role-management', [RoleController::class, 'store'])->middleware('superadmin')->name('role.store');
    Route::put('role-management/{id}/update', [RoleController::class, 'update'])->middleware('superadmin')->name('role.update');
    Route::delete('role-management/{id}', [RoleController::class, 'destroy'])->middleware('superadmin')->name('role.destroy');

    // Log Management
    Route::get('log-management', [LogController::class, 'index'])->middleware('superadmin')->name('log.index');

    // View Profile
    Route::get('/profile', [ProfileController::class, 'getProfile'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'profile'])->name('profile.store');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-photo', [ProfileController::class, 'changePhoto'])->name('profile.changePhoto');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');


    // Search and Export
    Route::get('/search', [SettingsController::class, 'search'])->middleware('superadmin')->name('search.store');
    Route::get('/export_user', [SettingsController::class, 'userExport'])->middleware('superadmin')->name('exportuser.store');
    Route::get('/export_menu', [SettingsController::class, 'menuExport'])->middleware('superadmin')->name('exportmenu.store');

    Route::get('/roles', [SettingsController::class, 'getRoles'])->middleware('superadmin')->name('api.roles');

    // Logut
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');

    // testing
    Route::post('useradd', [UserController::class, 'storeuser'])->name('storeuser');
    Route::get('user-men-testing', [TestingController::class, 'index'])->name('muser.testing');

//
});
