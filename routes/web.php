<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('user')->group(function () {
        Route::get('/list', [UserController::class, 'getListUser'])->name('user.list');
        Route::get('/detail/{id}', [UserController::class, 'viewUser'])->name('user.detail');
    });

    Route::controller(AreaController::class)->prefix('area')->group(function () {
        Route::get('/', 'index')->name('area.list');
        Route::get('/create', 'show')->name('area.create.show');
        Route::post('/create', 'create')->name('area.create.post');
    });
});
