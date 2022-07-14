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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/presensi-masuk', [App\Http\Controllers\API\AbsenController::class, 'presensiMasuk']);
Route::post('/sanctum/token', [App\Http\Controllers\API\Auth\LoginController::class, 'login'])->name('login.token');
