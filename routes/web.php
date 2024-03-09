<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'UserController@index')->middleware('checkrole:user');

Route::middleware('auth')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/', 'getListUser')->name('list-user');
        Route::prefix('user')->group(function () {
            Route::get('/list', 'getListUser')->name('list-user');
            Route::get('/detail/{id}', 'viewUser')->name('detail-user');
        });
    });
});
