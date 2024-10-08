<?php

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


Route::prefix('auth')
    ->controller(\App\Http\Controllers\Api\AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
    });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('unit-kerja')
//     ->controller(\App\Http\Controllers\Api\UnitKerjaController::class)
//     ->where([
//         'id' => '[0-9]+',
//     ])
//     ->middleware('auth:sanctum')
//     ->group(function () {
//         Route::get('/', 'index');
//     });