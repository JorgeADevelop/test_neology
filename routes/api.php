<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarControllers;
use App\Http\Controllers\UserControllers;
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

Route::post('/login', [AuthController::class, 'login']);

//Car resources
Route::apiResource('car-type', CarControllers\CarTypeController::class)
    ->except('show')
    ->middleware(['auth:sanctum']);
Route::apiResource('car', CarControllers\CarController::class)
    ->middleware(['auth:sanctum']);
Route::apiResource('car-binnacle', CarControllers\CarBinnacleController::class)
    ->except(['update', 'destroy'])
    ->middleware(['auth:sanctum']);
Route::post('/print-binnacle-dates', [CarControllers\CarBinnacleController::class, 'printBinnacleByDates'])
    ->middleware(['auth:sanctum']);

//User resources
Route::apiResource('user-type', UserControllers\UserTypeController::class)
    ->only('index')
    ->middleware(['auth:sanctum']);
Route::apiResource('user', UserControllers\UserController::class)
    ->except('update')
    ->middleware(['auth:sanctum']);
Route::apiResource('user-binnacle', UserControllers\UserBinnacleController::class)
    ->only('index')
    ->middleware(['auth:sanctum']);