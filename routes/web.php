<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DSAController;
use App\Http\Controllers\DayimController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ContactController;

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
    // return "ali";
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('check.permission:users-list');
    Route::get('/get_users', [UserController::class, 'get_users']);
    Route::get('change-password', [UserController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('change-password.update');

    Route::resource('products', ProductsController::class);
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index')->middleware('check.permission:users-list');
    Route::get('/get_products', [ProductsController::class, 'get_products']);
    
    Route::resource('dsa', DSAController::class);
    Route::get('/get_dsa_events', [DSAController::class, 'get_dsa_events']);

    Route::resource('dayim', DayimController::class);
    Route::get('/get_dayim_events', [DayimController::class, 'get_dayim_events']);

    Route::resource('roles', RoleController::class);
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('check.permission:roles-list');

    Route::resource('contacts', ContactController::class);
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index')->middleware('check.permission:contacts-view');
    Route::get('/get_contacts', [ContactController::class, 'get_contacts']);

    Route::get('/sheet', [GoogleSheetController::class, 'index'])->name('sheet.index');
    Route::get('/sheets/{id}', [GoogleSheetController::class, 'user_sheets'])->name('sheet.user_sheets');
    Route::get('/sheet/{id}', [GoogleSheetController::class, 'single'])->name('sheet.single');
    Route::get('/get_sheets/{id}', [GoogleSheetController::class, 'get_sheets']);


    Route::any('/generate-pdf/{id}', [GoogleSheetController::class, 'generatePDF'])->name('download.pdf');
});
