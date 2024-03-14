<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\WeekendController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\FrontHotelController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\TestimonialController;

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
});


