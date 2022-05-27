<?php

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

Route::get('login', [ 'as' => 'login', function () {
    return response()->json([
        'code'      => 401,
        'status'    => 'unauthorized',
        'message'   => 'Without permission',
        'data'      => null,
        'errors'    => [
            'Token does not have permission in this resource'
            ]
    ], 401, [
        'Content-Type' => 'application/json'
    ]);
}]);
