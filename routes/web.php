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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('user-management')->group(function () {
        Route::get('', [App\Http\Controllers\UserManagementController::class, 'index'])->name('user.index');
        Route::post('edit', [App\Http\Controllers\UserManagementController::class, 'edit'])->name('user.edit');
        Route::post('store', [App\Http\Controllers\UserManagementController::class, 'store'])->name('user.store');
        Route::put('update', [App\Http\Controllers\UserManagementController::class, 'update'])->name('user.update');
        Route::post('destroy', [App\Http\Controllers\UserManagementController::class, 'destroy'])->name('user.destroy');
    });
});

