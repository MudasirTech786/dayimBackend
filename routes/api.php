<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DSAController;
use App\Http\Controllers\DayimController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductsController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dsa_events', [DSAController::class, 'dsa_events_api']);
Route::get('/dm_events', [DayimController::class, 'dm_events_api']);

Route::post('/contact', [ContactController::class, 'storeApi']);

Route::get('/products', [ProductsController::class, 'apiIndex']);
