<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DSAController;
use App\Http\Controllers\DayimController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ProductsController;

use App\Models\Dayim;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('check.permission:users-list');
    Route::get('/get_users', [UserController::class, 'get_users']);
    
    Route::resource('roles', RoleController::class);
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('check.permission:roles-list');
    
    Route::resource('dayim', DayimController::class);
    Route::get('/get_dayim_events', [DayimController::class, 'get_dayim_events']);
    
    Route::resource('dsa', DSAController::class);
    Route::get('/get_dsa_events', [DSAController::class, 'get_dsa_events']);

    Route::resource('products', ProductsController::class);
});


