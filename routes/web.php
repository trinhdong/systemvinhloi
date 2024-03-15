<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/detail/{id}', [UserController::class, 'detail'])->name('user.detail');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/edit/{id}', [UserController::class, 'edit'])->name('user.update');
        Route::get('/add', [UserController::class, 'add'])->name('user.add');
        Route::post('/add', [UserController::class, 'add'])->name('user.create');
    });

    Route::controller(AreaController::class)->prefix('area')->group(function () {
        Route::get('/', 'index')->name('area.list');
        Route::get('/add', 'show')->name('area.create.show');
        Route::post('/add', 'create')->name('area.create.post');
        Route::get('/detail/{id}', 'detail')->name('area.detail');
        Route::get('/edit/{id}', 'edit')->name('area.edit');
        Route::post('/edit/{id}', 'update')->name('area.update');
        Route::delete('/delete/{id}', 'delete')->name('area.delete');
    });
});
