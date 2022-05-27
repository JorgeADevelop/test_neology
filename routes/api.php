<?php
use App\Http\Controllers\CarControllers;
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

Route::apiResource('car-type', CarControllers\CarTypeController::class)
    ->except('show');
Route::apiResource('car', CarControllers\CarController::class);
Route::apiResource('car-binnacle', CarControllers\CarBinnacleController::class)
    ->except(['update', 'destroy']);
