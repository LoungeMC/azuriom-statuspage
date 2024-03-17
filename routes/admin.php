<?php

use Azuriom\Plugin\StatusPage\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

//    Route::get('/', [AdminController::class, 'index'])->name('index');
Route::middleware('can:statuspage.admin')->group(function () {

    Route::resource('/', AdminController::class)->except('show');
    Route::post('/update-position', [AdminController::class, 'updateOrder'])->name('update-order');
    Route::post('/update', [AdminController::class, 'update'])->name('update');
    Route::resource('store', AdminController::class)->only('store');
    Route::get('/enable/{checkID}', [AdminController::class, 'enable'])->name('enable');
    Route::get('/disable/{checkID}', [AdminController::class, 'disable'])->name('disable');
    Route::get('/{checkID}/edit', [AdminController::class, 'edit'])->name('edit');
});
