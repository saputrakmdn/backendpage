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



Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'index'])->middleware('auth')->name('pegawai.index');
Route::post('/pegawai/store', [App\Http\Controllers\PegawaiController::class, 'store'])->middleware('auth')->name('pegawai.store');
Route::get('/pegawai/edit/{id}', [App\Http\Controllers\PegawaiController::class, 'edit'])->middleware('auth')->name('pegawai.edit');
Route::post('/pegawai/update/{id}', [App\Http\Controllers\PegawaiController::class, 'update'])->middleware('auth')->name('pegawai.update');
Route::post('/pegawai/delete/{id}', [App\Http\Controllers\PegawaiController::class, 'destroy'])->middleware('auth')->name('pegawai.delete');
