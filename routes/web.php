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
Auth::routes();

Route::get('/', 'UserController@index')->middleware('checkrole:user');

Route::middleware('auth')->group(function () {
    //user
    Route::controller(UserController::class)->group(function () {
        Route::get('/', 'getListUser')->name('list-user');
        Route::prefix('user')->group(function () {
            Route::get('/list', 'getListUser')->name('list-user');
            Route::get('/detail/{id}', 'viewUser')->name('detail-user');
        });
    });
});
